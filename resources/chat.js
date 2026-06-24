class ChatManager {
    constructor() {
        this.activeChatId = null;
        this.activeChatType = null;
        this.activeChatReceiverId = null;
        this.channel = null;
        this.typingTimer = null;
        this.isTyping = false;
        this.mediaRecorder = null;
        this.audioChunks = [];
        this.recordingTimer = null;
        this.recordingStartTime = null;
        this.isRecording = false;
        this.activeAudio = null;
        this.subscribedChannels = new Set();
        this.adminChannel = null;
        this.isOnline = true;
        this.replyToId = null;
        this._groupMembers = null;
        this.groupCreatedBy = null;
        this.onlyAdminsCanSend = false;

        // Pagination state (WhatsApp-style: load latest, scroll up for older)
        this.currentPage = 1;
        this.hasMorePages = true;
        this.isLoadingMessages = false;
        this.isInitialLoad = true;
        this.messageContainerScrollHandler = null;

        this.elements = {
            chatArea: document.getElementById('chatArea'),
            noChat: document.getElementById('noChatSelected'),
            chatHeaderArea: document.getElementById('chatHeaderArea'),
            messageContainer: document.getElementById('messageContainer'),
            messageInput: document.getElementById('messageInput'),
            chatName: document.getElementById('chatName'),
            chatAvatar: document.getElementById('chatAvatar'),
            chatStatusText: document.getElementById('chatStatusText'),
            typingIndicator: document.getElementById('typingIndicator'),
            onlineStatus: document.getElementById('onlineStatus'),
            memberCount: document.getElementById('memberCount')
        };

        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupInputDetection();
        this.setupInfiniteScroll();
        this.setupPusherListeners();
        this.setupAudioPlayback();
        this.setupReactionPickerCloser();
        console.log('[ChatManager] Initialized');
    }

    setupInfiniteScroll() {
        const container = this.elements.messageContainer;
        if (!container) return;

        if (this.messageContainerScrollHandler) {
            container.removeEventListener('scroll', this.messageContainerScrollHandler);
        }

        let scrollDebounce = null;
        this.messageContainerScrollHandler = () => {
            if (scrollDebounce) clearTimeout(scrollDebounce);
            scrollDebounce = setTimeout(() => {
                // Load older messages when scrolled near the top
                if (container.scrollTop < 80 && this.hasMorePages && !this.isLoadingMessages && !this.isInitialLoad) {
                    this.loadOlderMessages();
                }
            }, 60);
        };

        container.addEventListener('scroll', this.messageContainerScrollHandler);
    }

    isNearBottom() {
        const container = this.elements.messageContainer;
        if (!container) return true;
        return container.scrollHeight - container.scrollTop - container.clientHeight < 120;
    }

    setupEventListeners() {
        const input = this.elements.messageInput;
        if (input) {
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });
            input.addEventListener('input', () => this.handleTyping());
            input.addEventListener('focus', () => this.markMessagesAsRead());
        }

        const sendBtn = document.getElementById('sendMessageBtn');
        if (sendBtn) {
            sendBtn.addEventListener('click', () => this.sendMessage());
        }

        const voiceBtn = document.getElementById('voiceBtn');
        if (voiceBtn) {
            voiceBtn.addEventListener('click', () => this.toggleVoiceRecording());
        }

        const mediaInput = document.getElementById('mediaInput');
        if (mediaInput) {
            mediaInput.addEventListener('change', (e) => this.handleMediaUpload(e));
        }

        // Delete modal
        document.getElementById('deleteForEveryoneBtn')?.addEventListener('click', () => this.confirmDeleteMessage('everyone'));
        document.getElementById('deleteForMeBtn')?.addEventListener('click', () => this.confirmDeleteMessage('me'));
        document.getElementById('cancelDeleteBtn')?.addEventListener('click', () => this.closeDeleteModal());

        // Close delete modal on backdrop click
        document.getElementById('deleteMessageModal')?.addEventListener('click', (e) => {
            if (e.target === e.currentTarget) this.closeDeleteModal();
        });
    }

    setupPusherListeners() {
        if (!window.pusherInstance) return;

        window.pusherInstance.connection.bind('state_change', (states) => {
            const statusEl = document.getElementById('connectionStatus');
            if (statusEl) {
                if (states.current === 'connected') {
                    statusEl.innerHTML = '<span class="w-1.5 h-1.5 bg-[#25d366] rounded-full"></span><span class="font-medium">Connected</span>';
                    statusEl.className = 'flex items-center gap-1 text-[10px] text-[#25d366]';
                } else if (states.current === 'connecting') {
                    statusEl.innerHTML = '<span class="w-1.5 h-1.5 bg-[#f59e0b] rounded-full animate-pulse"></span><span class="font-medium">Connecting...</span>';
                    statusEl.className = 'flex items-center gap-1 text-[10px] text-[#f59e0b]';
                } else {
                    statusEl.innerHTML = '<span class="w-1.5 h-1.5 bg-[#ef4444] rounded-full"></span><span class="font-medium">Disconnected</span>';
                    statusEl.className = 'flex items-center gap-1 text-[10px] text-[#ef4444]';
                }
            }

            this.isOnline = states.current === 'connected' || states.current === 'connecting';
            // Re-apply send restriction UI to sync with new network state
            if (this.activeChatType === 'group' && this.groupCreatedBy != null) {
                this.updateSendRestrictionUI(this.onlyAdminsCanSend);
            } else {
                this.setSendControlsEnabled(this.isOnline);
            }
        });
    }

    setSendControlsEnabled(enabled) {
        if (this.elements.messageInput) {
            this.elements.messageInput.disabled = !enabled;
            this.elements.messageInput.placeholder = enabled ? 'Type a message...' : 'Reconnecting...';
        }
        const sendBtn = document.getElementById('sendMessageBtn');
        if (sendBtn) {
            sendBtn.disabled = !enabled;
            sendBtn.classList.toggle('opacity-50', !enabled);
            sendBtn.classList.toggle('cursor-not-allowed', !enabled);
        }
        const voiceBtn = document.getElementById('voiceBtn');
        if (voiceBtn) {
            voiceBtn.disabled = !enabled;
            voiceBtn.classList.toggle('opacity-50', !enabled);
            voiceBtn.classList.toggle('cursor-not-allowed', !enabled);
        }
        const mediaBtn = document.getElementById('mediaUploadBtn');
        if (mediaBtn) {
            mediaBtn.disabled = !enabled;
            mediaBtn.classList.toggle('opacity-50', !enabled);
            mediaBtn.classList.toggle('cursor-not-allowed', !enabled);
        }
    }

    setupAudioPlayback() {
        if (this._audioPlaybackSetup) return;
        this._audioPlaybackSetup = true;

        document.addEventListener('click', (e) => {
            const playBtn = e.target.closest('.voice-play-btn');
            if (!playBtn) return;

            const voiceMsg = playBtn.closest('.voice-message');
            if (!voiceMsg) return;

            const audioUrl = voiceMsg.dataset.audioUrl;
            if (!audioUrl) return;

            this.toggleVoicePlayback(playBtn, voiceMsg, audioUrl);
        });
    }

    toggleVoicePlayback(btn, container, url) {
        if (this.activeAudio && !this.activeAudio.paused && this.activeAudio.dataset.url === url) {
            this.activeAudio.pause();
            this.activeAudio.dataset.paused = 'true';
            const icon = btn.querySelector('i');
            if (icon) icon.className = 'fas fa-play text-xs ml-0.5';
            return;
        }

        if (this.activeAudio) {
            this.activeAudio.pause();
            if (this.prevAudioBtn) {
                const prevIcon = this.prevAudioBtn.querySelector('i');
                if (prevIcon) prevIcon.className = 'fas fa-play text-xs ml-0.5';
            }
        }

        const audio = new Audio(url);
        audio.dataset.url = url;
        audio.preload = 'auto';

        const progressBar = container.querySelector('.voice-progress');
        const durationEl = container.querySelector('.voice-duration');
        const icon = btn.querySelector('i');

        this.prevAudioBtn = btn;

        audio.addEventListener('loadedmetadata', () => {
            durationEl.textContent = this.formatAudioDuration(audio.duration);
        });

        audio.addEventListener('timeupdate', () => {
            if (audio.duration) {
                const pct = (audio.currentTime / audio.duration) * 100;
                if (progressBar) progressBar.style.width = pct + '%';
                durationEl.textContent = this.formatAudioDuration(audio.currentTime);
            }
        });

        audio.addEventListener('ended', () => {
            if (icon) icon.className = 'fas fa-play text-xs ml-0.5';
            if (progressBar) progressBar.style.width = '0%';
            durationEl.textContent = this.formatAudioDuration(audio.duration);
        this.activeAudio = null;
        this.prevAudioBtn = null;
        this.isRetryingQueue = false;
            this.prevAudioBtn = null;
        });

        audio.addEventListener('error', () => {});

        audio.play().then(() => {
            if (icon) icon.className = 'fas fa-pause text-xs';
            this.activeAudio = audio;
        }).catch(() => {});
    }

    formatAudioDuration(seconds) {
        if (!seconds || isNaN(seconds)) return '0:00';
        const m = Math.floor(seconds / 60);
        const s = Math.floor(seconds % 60);
        return m + ':' + s.toString().padStart(2, '0');
    }

    formatFileSize(bytes) {
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }

    setActiveChat(chatId, type, chatName, chatAvatar, receiverId = null, isSuperAdmin = false) {
        console.log('[ChatManager] setActiveChat:', { chatId, type, receiverId, isSuperAdmin });

        this.unsubscribeFromChannel();

        this.activeChatId = chatId;
        this.activeChatType = type;
        this.activeChatReceiverId = receiverId;
        this._groupMembers = null;
        this.groupCreatedBy = null;
        this.onlyAdminsCanSend = false;
        this.cancelReply();

        if (this.elements.noChat) this.elements.noChat.classList.add('hidden');
        if (this.elements.chatArea) this.elements.chatArea.classList.remove('hidden');
        if (this.elements.chatHeaderArea) this.elements.chatHeaderArea.classList.remove('hidden');
        if (this.elements.chatName) this.elements.chatName.textContent = chatName || 'Chat';
        if (this.elements.chatAvatar) {
            this.elements.chatAvatar.src = chatAvatar || '/images/default-avatar.png';
        }
        const tick = document.getElementById('superAdminTick');
        if (tick) {
            tick.classList.toggle('hidden', type !== 'personal' || !isSuperAdmin);
        }

        if (this.elements.typingIndicator) this.elements.typingIndicator.classList.add('hidden');
        if (this.elements.onlineStatus) this.elements.onlineStatus.classList.remove('hidden');

        if (this.elements.memberCount) {
            this.elements.memberCount.textContent = type === 'group' ? 'Group' : 'Direct';
        }

        if (chatId) {
            this.subscribeToChatChannel(chatId);
            this.loadMessages(chatId);
            this.markMessagesAsRead();
            if (type === 'group') {
                this.loadChatRestriction(chatId);
            }
        }

        // Mobile: switch to chat view
        if (window.innerWidth < 1024) {
            const sidebar = document.getElementById('chatSidebar');
            if (sidebar) sidebar.classList.add('hidden');
            if (this.elements.noChat) this.elements.noChat.classList.add('hidden');
            if (this.elements.chatArea) this.elements.chatArea.classList.remove('hidden');
        }
    }

    subscribeToAdminChannel() {
        console.log('[ChatManager] subscribeToAdminChannel called', {
            hasPusher: !!window.pusherInstance,
            currentAdminId: window.currentAdminId,
        });

        if (!window.pusherInstance || !window.currentAdminId) {
            console.error('[ChatManager] Cannot subscribe - missing pusher or adminId');
            return;
        }

        const channelName = `private-admin-chat-${window.currentAdminId}`;
        console.log('[ChatManager] Subscribing to:', channelName);

        if (this.subscribedChannels.has(channelName)) {
            console.log('[ChatManager] Already subscribed to:', channelName);
            return;
        }

        try {
            const channel = window.pusherInstance.subscribe(channelName);

            channel.bind('pusher:subscription_succeeded', () => {
                console.log('[ChatManager] Subscription SUCCESS:', channelName);
            });

            channel.bind('pusher:subscription_error', (err) => {
                console.error('[ChatManager] Subscription ERROR:', channelName, err);
            });

            channel.bind('message.sent', (data) => {
                console.log('[ChatManager] message.sent received:', data);
                this.handleIncomingMessage(data);
            });

            channel.bind('message.edited', (data) => {
                console.log('[ChatManager] message.edited received:', data);
                this.handleMessageEdited(data);
            });

            channel.bind('message.read', (data) => {
                console.log('[ChatManager] message.read received:', data);
                this.updateMessageReadStatus(data);
            });

            channel.bind('message.deleted', (data) => {
                console.log('[ChatManager] message.deleted received:', data);
                this.handleMessageDeleted(data);
            });

            channel.bind('user.typing', (data) => {
                console.log('[ChatManager] user.typing received:', data);
                this.handleUserTyping(data);
            });

            channel.bind('message.reacted', (data) => {
                console.log('[ChatManager] message.reacted received:', data);
                this.handleMessageReacted(data);
            });

            this.subscribedChannels.add(channelName);
            this.adminChannel = channel;
            console.log('[ChatManager] Admin channel subscribed:', channelName);
        } catch (error) {
            console.error('[ChatManager] Admin channel subscription failed:', error);
        }
    }

    subscribeToChatChannel(chatId) {
        if (!window.pusherInstance) {
            console.log('[ChatManager] Cannot subscribe to chat - no pusher');
            return;
        }

        // For personal directs, the always-on admin channel handles it
        if (this.activeChatType !== 'group') return;

        const channelName = `private-group-chat-${chatId}`;

        if (this.subscribedChannels.has(channelName)) return;

        try {
            const channel = window.pusherInstance.subscribe(channelName);

            channel.bind('pusher:subscription_succeeded', () => {
                console.log('[ChatManager] Group subscription SUCCESS:', channelName);
            });

            channel.bind('pusher:subscription_error', (err) => {
                console.error('[ChatManager] Group subscription ERROR:', channelName, err);
            });

            channel.bind('message.sent', (data) => {
                console.log('[ChatManager] message.sent received:', data);
                this.handleIncomingMessage(data);
            });

            channel.bind('message.edited', (data) => {
                console.log('[ChatManager] message.edited received:', data);
                this.handleMessageEdited(data);
            });

            channel.bind('message.read', (data) => {
                console.log('[ChatManager] message.read received:', data);
                this.updateMessageReadStatus(data);
            });

            channel.bind('user.typing', (data) => {
                console.log('[ChatManager] user.typing received:', data);
                this.handleUserTyping(data);
            });

            channel.bind('message.deleted', (data) => {
                console.log('[ChatManager] message.deleted received:', data);
                this.handleMessageDeleted(data);
            });

            channel.bind('message.reacted', (data) => {
                console.log('[ChatManager] message.reacted received:', data);
                this.handleMessageReacted(data);
            });

            channel.bind('member.kicked', (data) => {
                console.log('[ChatManager] member.kicked received:', data);
                this.handleMemberKicked(data);
            });

            this.subscribedChannels.add(channelName);
            this.channel = channel;
            console.log('[ChatManager] Subscribed to:', channelName);
        } catch (error) {
            console.error('[ChatManager] Channel subscription failed:', error);
        }
    }

    unsubscribeFromChannel() {
        if (this.channel && window.pusherInstance) {
            this.subscribedChannels.forEach(name => {
                // Keep the admin channel always active for direct messages
                if (name !== `private-admin-chat-${window.currentAdminId}`) {
                    try { window.pusherInstance.unsubscribe(name); } catch {}
                }
            });
            this.subscribedChannels.clear();
            if (this.adminChannel) {
                this.subscribedChannels.add(`private-admin-chat-${window.currentAdminId}`);
            }
            this.channel = null;
        }
    }

    handleIncomingMessage(message) {
        if (!message) return;

        const msgChatId = parseInt(message.chat_room_id);
        const activeId = parseInt(this.activeChatId);
        const senderId = parseInt(message.sender_id);
        const currentId = parseInt(window.currentAdminId);

        // Ignore messages for chats we're not viewing
        if (!activeId || msgChatId !== activeId) return;

        // Skip sender's own messages — already handled via optimistic UI + API
        // (except system_notification which is server-broadcast and not optimistically rendered)
        if (senderId === currentId && message.type !== 'system_notification') return;

        // Show notification if we're mentioned
        if (message.mentioned_admins && Array.isArray(message.mentioned_admins)) {
            const isMentioned = message.mentioned_admins.includes(currentId);
            if (isMentioned && senderId !== currentId) {
                this.showNotification('You were mentioned by ' + (message.sender_name || 'Someone'), 'info');
            }
        }

        this.addMessageToChat(message, false);
        this.markMessageAsRead(message.id);
    }

    handleMessageEdited(data) {
        const msgEl = document.getElementById('msg-' + data.id);
        if (!msgEl) return;

        const pEl = msgEl.querySelector('p');
        if (pEl) {
            pEl.textContent = data.message;
        }

        let editedSpan = msgEl.querySelector('.edited-label');
        if (!editedSpan) {
            const timeContainer = msgEl.querySelector('.flex.items-center.justify-end') ||
                msgEl.querySelector('[class*="flex"][class*="items-center"][class*="justify-end"]');
            if (timeContainer) {
                const label = document.createElement('span');
                label.className = 'text-[10px] text-[#8696a0] italic ml-1 edited-label';
                label.textContent = '(edited)';
                timeContainer.insertBefore(label, timeContainer.querySelector('span[class*="text-\\[10px\\]"]')?.nextSibling || null);
            }
        }
    }

    startEditMessage(messageId) {
        const msgEl = document.getElementById('msg-' + messageId);
        if (!msgEl) return;

        const pEl = msgEl.querySelector('p');
        const currentText = pEl ? pEl.textContent : '';

        const input = this.elements.messageInput;
        if (!input) return;

        input.value = currentText;
        input.focus();
        input.dataset.editId = messageId;
        input.dataset.editMode = 'true';

        this.showNotification('Editing message — press Enter to save', 'info');
    }

    cancelEdit() {
        const input = this.elements.messageInput;
        if (!input) return;
        delete input.dataset.editId;
        delete input.dataset.editMode;
        input.value = '';
    }

    startReply(messageId, senderName) {
        const msgEl = document.getElementById('msg-' + messageId);
        if (!msgEl) return;

        const pEl = msgEl.querySelector('p');
        const previewText = pEl ? pEl.textContent.substring(0, 80) : '';

        this.replyToId = parseInt(messageId);

        const preview = document.getElementById('replyPreview');
        const nameEl = document.getElementById('replyPreviewName');
        const textEl = document.getElementById('replyPreviewText');
        if (preview) preview.classList.remove('hidden');
        if (nameEl) nameEl.textContent = 'Replying to ' + (senderName || 'Unknown');
        if (textEl) textEl.textContent = previewText;

        const input = this.elements.messageInput;
        if (input) input.focus();
    }

    cancelReply() {
        this.replyToId = null;
        const preview = document.getElementById('replyPreview');
        if (preview) preview.classList.add('hidden');
    }

    async editMessageRequest(messageId, newText) {
        try {
            const res = await fetch(`/admin/chat/message/${messageId}/edit`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ message: newText }),
            });
            const data = await res.json();
            if (!data.status) {
                this.showNotification(data.error || 'Failed to edit message', 'error');
            } else {
                this.handleMessageEdited(data.message);
            }
        } catch (error) {
            console.error('[ChatManager] editMessage error:', error);
            this.showNotification('Failed to edit message', 'error');
        }
    }

    async loadMessages(chatId) {
        this.isInitialLoad = true;
        this.currentPage = 1;
        this.hasMorePages = true;
        this.showLoadingState();

        try {
            const endpoint = `/admin/chat/messages/${chatId}?type=${this.activeChatType}&page=1`;
            const res = await fetch(endpoint);
            const data = await res.json();

            if (this.elements.messageContainer) {
                this.elements.messageContainer.innerHTML = '';
            }

            if (data.status && Array.isArray(data.messages) && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    const isMine = parseInt(msg.sender_id) === parseInt(window.currentAdminId);
                    this.addMessageToChat(msg, isMine, false);
                });
                this.showEmptyState(false);
                this.hasMorePages = data.pagination?.has_more ?? false;
            } else {
                this.showEmptyState(true);
                this.hasMorePages = false;
            }

            this.scrollToBottom();
        } catch (error) {
            console.error('[ChatManager] Error loading messages:', error);
            this.showErrorState('Failed to load messages');
        } finally {
            this.isInitialLoad = false;
        }
    }

    async loadOlderMessages() {
        if (this.isLoadingMessages || !this.hasMorePages) return;

        const container = this.elements.messageContainer;
        if (!container) return;

        this.isLoadingMessages = true;
        this.currentPage++;

        // Save scroll height before load
        const prevScrollHeight = container.scrollHeight;
        const prevScrollTop = container.scrollTop;

        // Show a tiny loading indicator at top
        const loader = document.createElement('div');
        loader.id = 'older-loader';
        loader.className = 'text-center py-2 text-slate-400 text-xs';
        loader.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Loading older messages...';
        container.insertBefore(loader, container.firstChild);

        try {
            const endpoint = `/admin/chat/messages/${this.activeChatId}?type=${this.activeChatType}&page=${this.currentPage}`;
            const res = await fetch(endpoint);
            const data = await res.json();

            // Remove loader
            const loaderEl = document.getElementById('older-loader');
            if (loaderEl) loaderEl.remove();

            if (data.status && Array.isArray(data.messages) && data.messages.length > 0) {
                this.hasMorePages = data.pagination?.has_more ?? false;

                // Build HTML for older messages
                let html = '';
                data.messages.forEach(msg => {
                    const isMine = parseInt(msg.sender_id) === parseInt(window.currentAdminId);
                    html += this.createMessageBubble(msg, isMine, false);
                });

                // Insert at top and restore scroll
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                while (tempDiv.firstChild) {
                    container.insertBefore(tempDiv.firstChild, container.firstChild);
                }

                // Maintain scroll position so the "old" visible messages don't jump
                const newScrollHeight = container.scrollHeight;
                container.scrollTop = newScrollHeight - prevScrollHeight + prevScrollTop;
            } else {
                this.hasMorePages = false;
            }
        } catch (error) {
            console.error('[ChatManager] Error loading older messages:', error);
            const loaderEl = document.getElementById('older-loader');
            if (loaderEl) loaderEl.remove();
        } finally {
            this.isLoadingMessages = false;
        }
    }

    renderMessages(messages) {
        if (!this.elements.messageContainer) return;

        this.elements.messageContainer.innerHTML = '';

        if (!messages || messages.length === 0) {
            this.showEmptyState(true);
            return;
        }

        messages.forEach(msg => {
            const isMe = parseInt(msg.sender_id) === parseInt(window.currentAdminId);
            const html = this.createMessageBubble(msg, isMe);
            this.elements.messageContainer.insertAdjacentHTML('beforeend', html);
        });

        this.scrollToBottom();
    }

    createMessageBubble(msg, isMe, animate = true) {
        const time = msg.created_at
            ? new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
            : 'Just now';

        const readStatus = isMe ? (msg.is_read ? '\u2713\u2713' : '\u2713') : '';
        const animationClass = animate ? 'animate-fadeIn' : '';
        const sideClass = isMe ? 'items-end' : 'items-start';
        const rowClass = isMe ? 'flex-row-reverse' : 'flex-row';
        const bubbleWidth = 'max-w-[85%] md:max-w-[70%] lg:max-w-[65%]';
        const sentBg = 'bg-[#d9fdd3] text-[#111b21]';
        const sentRounded = 'rounded-[8px_8px_0_8px]';
        const recvBg = 'bg-white text-[#111b21] border border-[#e9edef]';
        const recvRounded = 'rounded-[0_8px_8px_8px]';
        const metaColor = 'text-[#8696a0]';

        const deleteBtn = isMe ? `
            <div class="relative flex-shrink-0 self-end mr-1">
                <button onclick="window.chatManager?.openDeleteModal(${msg.id})"
                        class="delete-msg-btn w-7 h-7 rounded-full bg-white border border-[#e9edef] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-50 hover:border-red-200 hover:text-red-500 text-[#8696a0]"
                        title="Delete">
                    <i class="fas fa-trash-alt text-[10px]"></i>
                </button>
            </div>
        ` : '';

        const actionBtns = isMe ? `
            <div class="relative flex-shrink-0 self-end mr-1 flex gap-0.5">
                <button onclick="window.chatManager?.openDeleteModal(${msg.id})"
                        class="delete-msg-btn w-7 h-7 rounded-full bg-white border border-[#e9edef] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-50 hover:border-red-200 hover:text-red-500 text-[#8696a0]"
                        title="Delete">
                    <i class="fas fa-trash-alt text-[10px]"></i>
                </button>
                ${msg.type === 'text' || !msg.type ? `
                <button onclick="window.chatManager?.startEditMessage(${msg.id})"
                        class="edit-msg-btn w-7 h-7 rounded-full bg-white border border-[#e9edef] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-500 text-[#8696a0]"
                        title="Edit">
                    <i class="fas fa-edit text-[10px]"></i>
                </button>
                ` : ''}
            </div>
        ` : '';

        const replyBtn = `
            <div class="relative flex-shrink-0 self-end mr-1">
                <button onclick="window.chatManager?.startReply('${msg.id}', '${this.escapeHtml(msg.sender_name || 'Unknown')}')"
                        class="reply-msg-btn w-7 h-7 rounded-full bg-white border border-[#e9edef] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-green-50 hover:border-green-200 hover:text-green-600 text-[#8696a0]"
                        title="Reply">
                    <i class="fas fa-reply text-[10px]"></i>
                </button>
            </div>
        `;

        const senderName = !isMe && this.activeChatType === 'group' && msg.sender_name
            ? `<div class="text-[11px] font-medium text-[#00a884] mb-1 flex items-center gap-1">
                ${this.escapeHtml(msg.sender_name)}
                ${msg.sender_role_slug === 'super_admin' ? '<i class="fas fa-check-circle text-blue-500 text-[9px]"></i>' : ''}
               </div>`
            : '';

        const reactionBar = `
            <div class="reactions-bar flex flex-wrap gap-1 mt-1 ${msg.reactions?.length ? '' : 'hidden'}" data-msg-id="${msg.id}">
                ${(msg.reactions || []).map(r => `
                    <button onclick="window.chatManager?.toggleReaction(${msg.id}, '${r.emoji}')"
                            class="reaction-btn inline-flex items-center gap-1 text-xs px-1.5 py-0.5 rounded-full border transition-all ${r.reacted_by_me ? 'bg-[#d9fdd3] border-[#00a884]' : 'bg-white border-[#e9edef] hover:bg-[#f0f2f5]'}"
                            data-emoji="${r.emoji}" data-count="${r.count}">
                        <span>${r.emoji}</span>
                        <span class="reaction-count font-medium text-[10px] text-[#667781]">${r.count}</span>
                    </button>
                `).join('')}
            </div>
        `;

        const reactionPicker = `
            <div id="reaction-picker-${msg.id}" class="reaction-picker hidden mt-1 bg-white border border-[#e9edef] rounded-lg shadow-lg px-2 py-1 flex gap-1 z-20">
                ${['👍', '❤️', '😂', '😮', '😢', '🙏'].map(e => `
                    <button onclick="window.chatManager?.toggleReaction(${msg.id}, '${e}'); window.chatManager?.closeAllReactionPickers()"
                            class="w-8 h-8 hover:bg-[#f0f2f5] rounded-lg flex items-center justify-center text-lg transition-all">
                        ${e}
                    </button>
                `).join('')}
            </div>
        `;

        const reactionTrigger = `
            <button onclick="window.chatManager?.toggleReactionPicker(${msg.id})"
                    class="reaction-trigger absolute -bottom-2.5 ${isMe ? 'right-2' : 'left-2'} w-5 h-5 rounded-full bg-white border border-[#e9edef] flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-[#f0f2f5] text-[#8696a0] cursor-pointer text-xs"
                    title="React">
                😊
            </button>
        `;

        if (msg.type === 'text' || !msg.type) {
            const editedLabel = msg.is_edited ? '<span class="text-[10px] text-[#8696a0] italic ml-1">(edited)</span>' : '';
            const replyPreview = msg.reply_to ? `
                <div class="flex items-start gap-2 mb-1.5 pb-1.5 border-l-4 border-[#00a884] pl-2.5 bg-[#00000008] rounded-r-md -mx-2 -mt-1 pt-1.5 px-2">
                    <div class="flex-1 min-w-0">
                        <span class="text-[11px] font-medium text-[#00a884] block truncate">${this.escapeHtml(msg.reply_to.sender_name || '')}</span>
                        <span class="text-[12px] text-[#667781] block truncate">${this.escapeHtml(msg.reply_to.message || '')}</span>
                    </div>
                </div>
            ` : '';
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentBg : recvBg} ${isMe ? sentRounded : recvRounded} px-3.5 py-2 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            ${senderName}
                            ${replyPreview}
                            <p class="text-[14.5px] leading-[1.45] whitespace-normal break-words">${this.highlightMentions(msg.message)}</p>
                            <div class="flex items-center justify-end gap-1 -mb-0.5">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                                ${editedLabel}
                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'image') {
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentRounded : recvRounded} overflow-hidden shadow-[0_1px_0.5px_rgba(0,0,0,0.07)] relative ${isMe ? '' : 'bg-white border border-[#e9edef]'}">
                            <img src="${msg.message}" alt="Image" class="w-full max-h-[400px] object-contain" loading="lazy">
                            <div class="flex items-center justify-end gap-1 px-3 py-1 ${isMe ? 'bg-[#d9fdd3]' : 'bg-white'}">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'audio') {
            const audioWidth = 'max-w-[92%] sm:max-w-[85%] md:max-w-[78%] lg:max-w-[72%]';
            const audioBg = isMe ? sentBg : 'bg-[#f0f2f5] text-[#111b21]';
            const audioRounded = isMe ? sentRounded : 'rounded-[0_8px_8px_8px]';
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${audioWidth} ${audioBg} ${audioRounded} px-3 py-2 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            <div class="voice-message cursor-pointer" data-audio-url="${this.escapeHtml(msg.message)}">
                                <div class="flex items-center gap-2.5">
                                    <button class="voice-play-btn w-9 h-9 rounded-full flex items-center justify-center flex-shrink-0 transition-all hover:scale-105 active:scale-95 bg-[#00a884] hover:bg-[#009977] text-white shadow-sm">
                                        <i class="fas fa-play text-xs ml-0.5"></i>
                                    </button>
                                    <div class="flex-1 min-w-0">
                                        <div class="voice-wave text-[#00a884]">
                                            ${'<span></span>'.repeat(10)}
                                        </div>
                                        <div class="mt-1.5">
                                            <div class="h-[3px] bg-[#e9edef]/80 rounded-full overflow-hidden">
                                                <div class="voice-progress h-full bg-[#00a884] rounded-full transition-all duration-150" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center mt-1">
                                            <span class="voice-duration text-[10px] ${metaColor} font-mono tabular-nums">0:00</span>
                                            <div class="flex items-center gap-1">
                                                <span class="text-[10px] ${metaColor}">${time}</span>
                                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'file') {
            const fileSize = msg.file_size ? this.formatFileSize(msg.file_size) : '';
            const ext = msg.file_name ? msg.file_name.split('.').pop().toUpperCase() : 'FILE';
            const icons = { 'PDF': 'fa-file-pdf', 'DOC': 'fa-file-word', 'DOCX': 'fa-file-word', 'XLS': 'fa-file-excel', 'XLSX': 'fa-file-excel', 'ZIP': 'fa-file-archive', 'RAR': 'fa-file-archive' };
            const icon = icons[ext] || (msg.file_name && msg.file_name.match(/\.(jpg|jpeg|png|gif|webp)$/i) ? 'fa-file-image' : 'fa-file-alt');
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentBg : recvBg} ${isMe ? sentRounded : recvRounded} px-3.5 py-2.5 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            <a href="${msg.message}" target="_blank" class="flex items-center gap-3 ${isMe ? 'text-[#111b21]' : 'text-[#111b21]'} transition-colors">
                                <div class="w-10 h-10 rounded-lg ${isMe ? 'bg-[#e9edef]' : 'bg-[#f0f2f5]'} flex items-center justify-center flex-shrink-0">
                                    <i class="fas ${icon} text-base ${isMe ? 'text-[#54656f]' : 'text-[#54656f]'}"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-sm font-medium truncate block leading-tight">${this.escapeHtml(msg.file_name || 'File')}</span>
                                    ${fileSize ? `<span class="text-[10px] ${metaColor} mt-0.5 block">${fileSize} · ${ext}</span>` : ''}
                                </div>
                                <div class="w-7 h-7 rounded-lg ${isMe ? 'bg-[#e9edef] hover:bg-[#d9d9d9]' : 'bg-[#f0f2f5] hover:bg-[#e9edef]'} flex items-center justify-center transition-colors flex-shrink-0">
                                    <i class="fas fa-download text-xs text-[#54656f]"></i>
                                </div>
                            </a>
                            <div class="flex items-center justify-end gap-1 mt-1.5">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        // ─── Card types ─────────────────────────────────────
        if (msg.type === 'order_card') {
            const meta = msg.metadata || {};
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentBg : recvBg} ${isMe ? sentRounded : recvRounded} p-0 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            <div class="bg-white border border-[#e9edef] rounded-lg overflow-hidden shadow-sm min-w-[220px]">
                                <div class="bg-[#00a884] px-3 py-2 flex items-center gap-1.5">
                                    <i class="fas fa-shopping-cart text-white text-xs"></i>
                                    <span class="text-white text-xs font-medium">Order #${this.escapeHtml(meta.order_code || '')}</span>
                                </div>
                                <div class="p-3 space-y-1">
                                    <div class="flex justify-between text-xs">
                                        <span class="text-[#667781]">Status</span>
                                        <span class="font-medium capitalize text-[#111b21]">${this.escapeHtml(meta.status || '')}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-[#667781]">Customer</span>
                                        <span class="font-medium text-[#111b21] truncate ml-2">${this.escapeHtml(meta.customer_name || '')}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span class="text-[#667781]">Items</span>
                                        <span class="font-medium text-[#111b21]">${meta.items_count ?? ''}</span>
                                    </div>
                                    <div class="flex justify-between text-xs border-t border-[#e9edef] pt-1.5 mt-1.5">
                                        <span class="text-[#667781]">Total</span>
                                        <span class="font-semibold text-[#111b21]">$${meta.total ? Number(meta.total).toFixed(2) : ''}</span>
                                    </div>
                                </div>
                                <a href="/admin/orders/${meta.entity_id ?? ''}" target="_blank" class="block text-center py-1.5 bg-[#f0f2f5] text-[#00a884] text-[10px] font-medium hover:bg-[#e9edef] transition-colors border-t border-[#e9edef]">
                                    <i class="fas fa-external-link-alt mr-1"></i> View Order
                                </a>
                            </div>
                            <div class="flex items-center justify-end gap-1 px-2 py-1">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'product_card') {
            const meta = msg.metadata || {};
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentBg : recvBg} ${isMe ? sentRounded : recvRounded} p-0 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            <div class="bg-white border border-[#e9edef] rounded-lg overflow-hidden shadow-sm min-w-[200px]">
                                <div class="flex">
                                    <div class="w-14 h-14 bg-[#f0f2f5] flex-shrink-0 flex items-center justify-center">
                                        <img src="${meta.image || '/images/default-product.png'}" class="w-full h-full object-cover" onerror="this.style.display='none'" loading="lazy">
                                    </div>
                                    <div class="p-2.5 flex-1 min-w-0">
                                        <p class="text-sm font-medium text-[#111b21] truncate leading-tight">${this.escapeHtml(meta.name || '')}</p>
                                        <p class="text-[10px] text-[#667781] truncate">${this.escapeHtml(meta.slug || '')}</p>
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="text-sm font-bold text-[#00a884]">$${meta.price ? Number(meta.price).toFixed(2) : ''}</span>
                                            <span class="text-[10px] ${(meta.stock ?? 0) > 0 ? 'text-[#25d366]' : 'text-[#ea0038]'} font-medium">
                                                ${(meta.stock ?? 0) > 0 ? `In Stock (${meta.stock})` : 'Out of Stock'}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <a href="/admin/products/${meta.slug || ''}/edit" target="_blank" class="block text-center py-1.5 bg-[#f0f2f5] text-[#54656f] text-[10px] font-medium hover:bg-[#e9edef] transition-colors border-t border-[#e9edef]">
                                    <i class="fas fa-external-link-alt mr-1"></i> View Product
                                </a>
                            </div>
                            <div class="flex items-center justify-end gap-1 px-2 py-1">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'user_card') {
            const meta = msg.metadata || {};
            const initial = (meta.name || '?').charAt(0).toUpperCase();
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col ${sideClass} mb-0.5 ${animationClass}">
                    <div class="flex ${rowClass} items-end gap-0.5 group max-w-full">
                        ${actionBtns}
                        ${!isMe ? replyBtn : ''}
                        <div class="${bubbleWidth} ${isMe ? sentBg : recvBg} ${isMe ? sentRounded : recvRounded} p-0 relative shadow-[0_1px_0.5px_rgba(0,0,0,0.07)]">
                            <div class="bg-white border border-[#e9edef] rounded-lg overflow-hidden shadow-sm min-w-[200px] p-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full bg-[#00a884] flex items-center justify-center text-white text-xs font-bold flex-shrink-0">${initial}</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-[#111b21] truncate leading-tight">${this.escapeHtml(meta.name || '')}</p>
                                        <p class="text-[10px] text-[#667781] truncate">${this.escapeHtml(meta.email || '')}</p>
                                    </div>
                                </div>
                                <div class="flex mt-2.5 pt-2.5 border-t border-[#e9edef]">
                                    <div class="text-center flex-1">
                                        <p class="text-sm font-bold text-[#111b21]">${meta.total_orders ?? 0}</p>
                                        <p class="text-[10px] text-[#8696a0]">Orders</p>
                                    </div>
                                    <div class="text-center flex-1 border-l border-[#e9edef]">
                                        <p class="text-sm font-bold text-[#111b21]">$${meta.total_spent ? Number(meta.total_spent).toFixed(2) : '0.00'}</p>
                                        <p class="text-[10px] text-[#8696a0]">Spent</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-1 px-2 py-1">
                                <span class="text-[10px] ${metaColor}">${time}</span>
                                ${isMe ? `<span id="msg-status-${msg.id}" class="text-[10px] ${msg.is_read ? 'text-[#53bdeb]' : metaColor}">${readStatus}</span>` : ''}
                            </div>
                            ${reactionTrigger}
                        </div>
                    </div>
                    ${reactionBar}
                    ${reactionPicker}
                </div>
            `;
        }

        if (msg.type === 'system_notification') {
            const meta = msg.metadata || {};
            const actionMeta = meta.entity_type === 'order'
                ? { url: `/admin/orders/${meta.entity_id}/edit`, label: 'View Order' }
                : meta.entity_type === 'product'
                    ? { url: `/admin/products/${meta.entity_id}/edit`, label: 'View Product' }
                    : null;
            return `
                <div id="msg-${msg.id}" class="message-bubble flex flex-col items-center mb-0.5 ${animationClass}">
                    <div class="max-w-[85%] md:max-w-[70%] lg:max-w-[65%]">
                        <div class="bg-[#f0f5fa] border border-[#d6e4f0] rounded-lg px-4 py-2.5 text-center shadow-[0_1px_0.5px_rgba(0,0,0,0.05)]">
                            <div class="text-lg mb-1">\u{1F916}</div>
                            <p class="text-[13px] text-[#41525d] leading-[1.4] whitespace-normal break-words">${this.escapeHtml(msg.message || '')}</p>
                            <div class="flex items-center justify-center gap-2 mt-1.5">
                                <span class="text-[10px] text-[#8696a0] font-medium uppercase tracking-wide">System</span>
                                <span class="text-[8px] text-[#8696a0]">\u2022</span>
                                <span class="text-[10px] text-[#8696a0]">${time}</span>
                            </div>
                            ${actionMeta ? `<a href="${actionMeta.url}" target="_blank" class="inline-flex items-center gap-1 mt-1.5 text-[11px] text-[#00a884] font-medium hover:underline">${actionMeta.label} <i class="fas fa-external-link-alt text-[9px]"></i></a>` : ''}
                        </div>
                    </div>
                </div>
            `;
        }

        return '';
    }

    addMessageToChat(message, isMine = false, animate = true) {
        if (!this.elements.messageContainer) return;

        if (this.elements.messageContainer.innerHTML.includes('No messages yet') ||
            this.elements.messageContainer.innerHTML.includes('Loading messages')) {
            this.elements.messageContainer.innerHTML = '';
        }

        const html = this.createMessageBubble(message, isMine, animate);
        this.elements.messageContainer.insertAdjacentHTML('beforeend', html);

        // Only auto-scroll to bottom if user is near the bottom
        if (isMine || this.isNearBottom()) {
            this.scrollToBottom();
        }
    }

    getSocketId() {
        return window.pusherInstance?.connection?.socket_id || null;
    }

    authHeaders(extra = {}) {
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
            ...extra,
        };
        const socketId = this.getSocketId();
        if (socketId) {
            headers['X-Socket-ID'] = socketId;
        }
        return headers;
    }

    async sendMessage() {
        const input = this.elements.messageInput;
        const messageText = input?.value.trim();

        if (!messageText || !this.activeChatId) return;

        // Check if we're in edit mode
        const editId = input?.dataset.editId;
        if (editId) {
            await this.editMessageRequest(parseInt(editId), messageText);
            input.value = '';
            delete input.dataset.editId;
            delete input.dataset.editMode;
            return;
        }

        // If offline, queue directly without optimistic UI
        if (!this.isOnline) {
            this.queueFailedMessage(messageText);
            if (input) input.value = '';
            return;
        }

        this.stopTyping();

        const payload = {
            message: messageText,
            type: this.activeChatType,
            chat_room_id: this.activeChatType === 'group' ? this.activeChatId : null,
            receiver_id: this.activeChatType === 'personal' ? this.activeChatReceiverId : null,
            reply_to_id: this.replyToId || null,
        };

        const optimisticMessage = {
            id: 'temp-' + Date.now(),
            message: messageText,
            sender_id: parseInt(window.currentAdminId),
            sender_name: 'You',
            sender_pic: '/images/default-avatar.png',
            created_at: new Date().toISOString(),
            is_optimistic: true,
            is_read: false,
            reply_to: this.replyToId ? {
                id: this.replyToId,
                sender_name: (document.getElementById('replyPreviewName')?.textContent || '').replace('Replying to ', '') || 'Someone',
                message: document.getElementById('replyPreviewText')?.textContent || '',
            } : null,
        };

        this.addMessageToChat(optimisticMessage, true);
        if (input) input.value = '';
        this.cancelReply();

        try {
            const res = await fetch('/admin/chat/send', {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify(payload),
            });

            const data = await res.json();

            if (!data.status) {
                this.showNotification('Failed to send message', 'error');
                this.removeOptimisticMessage(optimisticMessage.id);
            } else {
                this.replaceOptimisticMessage(optimisticMessage.id, data.message);
                if (window.sidebarManager) window.sidebarManager.refreshChatList();
            }
        } catch (error) {
            console.error('[ChatManager] Send error:', error);
            // If network error, queue the message for retry
            if (error instanceof TypeError || error.message?.includes('fetch')) {
                this.queueFailedMessage(messageText);
            } else {
                this.showNotification('Failed to send message', 'error');
            }
            this.removeOptimisticMessage(optimisticMessage.id);
        }
    }

    replaceOptimisticMessage(tempId, realMessage) {
        const tempEl = document.getElementById('msg-' + tempId);
        if (tempEl) tempEl.remove();
        this.addMessageToChat(realMessage, true);
    }

    removeOptimisticMessage(messageId) {
        const el = document.getElementById('msg-' + messageId);
        if (el) el.remove();
    }

    // ─── Send Rich Card ──────────────────────────────────────

    async sendCard(cardType, entityId) {
        if (!this.activeChatId) return;

        const payload = {
            card_type: cardType,
            entity_id: entityId,
            type: this.activeChatType,
            chat_room_id: this.activeChatType === 'group' ? this.activeChatId : null,
            receiver_id: this.activeChatType === 'personal' ? this.activeChatReceiverId : null,
        };

        const optimisticId = 'card-' + Date.now();
        this.addMessageToChat({
            id: optimisticId,
            type: cardType,
            metadata: { card_type: cardType, entity_id: entityId },
            message: 'Sending...',
            sender_id: parseInt(window.currentAdminId),
            created_at: new Date().toISOString(),
            is_optimistic: true,
        }, true);

        try {
            const res = await fetch('/admin/chat/send-card', {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify(payload),
            });
            const data = await res.json();
            this.removeOptimisticMessage(optimisticId);
            if (data.status) {
                this.addMessageToChat(data.message, true);
                if (window.sidebarManager) window.sidebarManager.refreshChatList();
            } else {
                this.showNotification(data.error || 'Failed to send card', 'error');
            }
        } catch (error) {
            this.removeOptimisticMessage(optimisticId);
            console.error('[ChatManager] sendCard error:', error);
            this.showNotification('Failed to send card', 'error');
        }
    }

    // ─── Card Search + Suggestions ───────────────────────────

    async searchAndSuggest(type, query) {
        const container = document.getElementById('cardSuggestions');
        if (!container) return;

        if (!query || query.length < 1) {
            container.classList.add('hidden');
            return;
        }

        container.innerHTML = '<div class="p-3 text-center text-xs text-[#8696a0]"><i class="fas fa-spinner fa-spin mr-1"></i> Searching...</div>';
        container.classList.remove('hidden');

        try {
            const endpoint = type === 'order' ? '/admin/chat/orders/search'
                : type === 'product' ? '/admin/chat/products/search'
                : '/admin/chat/users/search';
            const res = await fetch(`${endpoint}?q=${encodeURIComponent(query)}`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();

            if (!data.status || !data.data?.length) {
                container.innerHTML = '<div class="p-3 text-center text-xs text-[#8696a0]">No results found</div>';
                return;
            }

            const typeLabel = { order: '📦 Order', product: '🛍️ Product', user: '👤 Customer' };
            container.innerHTML = data.data.map(item => {
                const label = type === 'order'
                    ? `#${item.order_code} — ${item.customer_name} ($${Number(item.total).toFixed(2)})`
                    : type === 'product'
                        ? `${item.name} — $${Number(item.price).toFixed(2)}`
                        : `${item.name} — ${item.email} (${item.total_orders} orders)`;
                return `<div class="card-suggestion-item px-3 py-2 cursor-pointer text-xs text-[#111b21] flex items-center gap-2" data-id="${item.id}">
                    <span>${typeLabel[type]}</span>
                    <span class="flex-1 truncate">${this.escapeHtml(label)}</span>
                </div>`;
            }).join('');

            container.querySelectorAll('.card-suggestion-item').forEach(el => {
                el.addEventListener('click', () => {
                    const cardType = type === 'order' ? 'order_card' : type === 'product' ? 'product_card' : 'user_card';
                    this.sendCard(cardType, parseInt(el.dataset.id));
                    container.classList.add('hidden');
                    if (this.elements.messageInput) this.elements.messageInput.value = '';
                });
            });
        } catch (error) {
            console.error('[Chat] Search error:', error);
            container.innerHTML = '<div class="p-3 text-center text-xs text-[#ea0038]">Search failed</div>';
        }
    }

    closeCardSuggestions() {
        const container = document.getElementById('cardSuggestions');
        if (container) container.classList.add('hidden');
    }

    // ─── Input Pattern Detection ─────────────────────────────

    setupInputDetection() {
        const input = this.elements.messageInput;
        if (!input) return;

        let detectionTimer = null;
        let prefixType = null;
        let currentPrefixQuery = '';

        input.addEventListener('input', () => {
            const text = input.value;
            const words = text.split(/\s+/);
            const lastWord = words[words.length - 1] || '';

            // Close suggestions when input is cleared
            if (!text.trim()) {
                this.closeCardSuggestions();
                this.closeMentionList();
                return;
            }

            // @ prefix → mention autocomplete in groups, order search in personal
            const atMatch = lastWord.match(/^@(.+)/);
            if (atMatch) {
                const mentionQuery = atMatch[1];
                if (this.activeChatType === 'group' && mentionQuery.length > 0) {
                    this.showMentionList(mentionQuery);
                    return;
                } else {
                    prefixType = 'order';
                    currentPrefixQuery = mentionQuery;
                    clearTimeout(detectionTimer);
                    detectionTimer = setTimeout(() => {
                        this.searchAndSuggest('order', currentPrefixQuery);
                    }, 300);
                    return;
                }
            }

            // # prefix → product search
            const hashMatch = lastWord.match(/^#(.+)/);
            if (hashMatch) {
                prefixType = 'product';
                currentPrefixQuery = hashMatch[1];
                clearTimeout(detectionTimer);
                detectionTimer = setTimeout(() => {
                    this.searchAndSuggest('product', currentPrefixQuery);
                }, 300);
                return;
            }

            // Fallback: slash commands (/order, /product)
            const slashMatch = text.match(/^\/(order|product)\s+(.*)/i);
            if (slashMatch) {
                prefixType = slashMatch[1].toLowerCase();
                currentPrefixQuery = slashMatch[2];
                clearTimeout(detectionTimer);
                detectionTimer = setTimeout(() => {
                    const type = prefixType === 'order' ? 'order' : 'product';
                    this.searchAndSuggest(type, currentPrefixQuery);
                }, 300);
                return;
            }

            prefixType = null;
            this.closeCardSuggestions();
            this.closeMentionList();
        });

        // Close on blur
        input.addEventListener('blur', () => {
            setTimeout(() => {
                this.closeCardSuggestions();
                this.closeMentionList();
            }, 200);
        });

        // Close on Escape
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeCardSuggestions();
                this.closeMentionList();
                this.cancelReply();
                this.cancelEdit();
                input.blur();
            }
        });
    }

    // ─── Mention autocomplete ──────────────────────────────

    showMentionList(query) {
        if (!this.activeChatId || this.activeChatType !== 'group') return;

        const container = document.getElementById('mentionList');
        if (!container) return;

        // Get group members from the group info cached data
        let members = this._groupMembers || [];
        if (members.length === 0) {
            container.innerHTML = '<div class="p-3 text-center text-xs text-[#8696a0]">Loading members...</div>';
            container.classList.remove('hidden');
            this.fetchGroupMembers().then(() => {
                members = this._groupMembers || [];
                this.renderMentionList(container, members, query);
            });
            return;
        }

        this.renderMentionList(container, members, query);
    }

    async fetchGroupMembers() {
        try {
            const res = await fetch(`/admin/chat/group/${this.activeChatId}/members`);
            const data = await res.json();
            if (data.status && Array.isArray(data.data)) {
                this._groupMembers = data.data;
            }
        } catch (e) {
            console.error('[ChatManager] Failed to fetch group members:', e);
        }
    }

    renderMentionList(container, members, query) {
        const q = query.toLowerCase();
        const filtered = members.filter(m =>
            m.name && m.name.toLowerCase().includes(q)
        );

        if (filtered.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.innerHTML = filtered.map(m => `
            <div class="mention-item px-3 py-2 cursor-pointer text-xs text-[#111b21] flex items-center gap-2 hover:bg-[#f0f2f5]"
                 data-name="${this.escapeHtml(m.name)}">
                <div class="w-6 h-6 rounded-full bg-[#00a884] flex items-center justify-center text-white text-[9px] font-bold flex-shrink-0">
                    ${(m.name || '?')[0].toUpperCase()}
                </div>
                <span class="font-medium">${this.escapeHtml(m.name)}</span>
            </div>
        `).join('');

        container.classList.remove('hidden');

        container.querySelectorAll('.mention-item').forEach(el => {
            el.addEventListener('click', () => {
                this.insertMention(el.dataset.name);
            });
        });
    }

    insertMention(name) {
        const input = this.elements.messageInput;
        if (!input) return;

        const text = input.value;
        const words = text.split(/\s+/);
        words[words.length - 1] = '@' + name + ' ';
        input.value = words.join(' ') + ' ';
        input.focus();
        this.closeMentionList();
    }

    closeMentionList() {
        const container = document.getElementById('mentionList');
        if (container) container.classList.add('hidden');
    }

    // ─── Offline message queue ─────────────────────────────
    getQueue() {
        try {
            return JSON.parse(localStorage.getItem('chat_offline_queue') || '[]');
        } catch { return []; }
    }

    saveQueue(queue) {
        localStorage.setItem('chat_offline_queue', JSON.stringify(queue));
        this.updateQueueUI();
    }

    queueFailedMessage(messageText) {
        const queue = this.getQueue();
        queue.push({
            id: 'q-' + Date.now(),
            message: messageText,
            chat_room_id: this.activeChatId,
            receiver_id: this.activeChatReceiverId,
            type: this.activeChatType,
            created_at: new Date().toISOString(),
        });
        this.saveQueue(queue);
        this.showNotification('Message queued — will send when connection restores', 'info');
    }

    updateQueueUI() {
        const queue = this.getQueue();
        const retryBtn = document.getElementById('retryQueueBtn');
        const countEl = document.getElementById('queueCount');
        if (retryBtn) retryBtn.classList.toggle('hidden', queue.length === 0);
        if (countEl) countEl.textContent = queue.length;
    }

    async retryAllQueued() {
        if (this.isRetryingQueue) return;
        this.isRetryingQueue = true;

        const queue = this.getQueue();
        if (!queue.length) {
            this.isRetryingQueue = false;
            return;
        }

        const retryBtn = document.getElementById('retryQueueBtn');
        if (retryBtn) {
            retryBtn.disabled = true;
            retryBtn.innerHTML = '<i class="fas fa-spinner fa-spin text-[10px]"></i> Sending...';
        }

        const failed = [];
        for (const item of queue) {
            try {
                const res = await fetch('/admin/chat/send', {
                    method: 'POST',
                    headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                    body: JSON.stringify({
                        message: item.message,
                        type: item.type,
                        chat_room_id: item.type === 'group' ? item.chat_room_id : null,
                        receiver_id: item.type === 'personal' ? item.receiver_id : null,
                    }),
                });
                const data = await res.json();
                if (!data.status) failed.push(item);
            } catch {
                failed.push(item);
            }
        }

        this.saveQueue(failed);
        if (window.sidebarManager) window.sidebarManager.refreshChatList();

        if (retryBtn) {
            retryBtn.disabled = false;
            retryBtn.innerHTML = '<i class="fas fa-paper-plane text-[10px]"></i> Retry (<span id="queueCount">' + failed.length + '</span>)';
        }

        if (failed.length === 0) {
            this.showNotification('All queued messages sent successfully!', 'success');
        }

        this.isRetryingQueue = false;
    }

    async handleReconnect() {
        // First, send queued messages
        await this.retryAllQueued();

        // Then refresh sidebar
        if (window.sidebarManager) window.sidebarManager.refreshChatList();

        // Then refresh active chat to show server-side state
        if (this.activeChatId) {
            this.loadMessages(this.activeChatId);
        }

        this.showNotification('Connection restored', 'success');
    }

    // Delete message
    openDeleteModal(messageId) {
        this.pendingDeleteId = messageId;
        const modal = document.getElementById('deleteMessageModal');
        if (modal) modal.classList.remove('hidden');
    }

    closeDeleteModal() {
        this.pendingDeleteId = null;
        const modal = document.getElementById('deleteMessageModal');
        if (modal) modal.classList.add('hidden');
    }

    async confirmDeleteMessage(mode) {
        const messageId = this.pendingDeleteId;
        if (!messageId) return;

        this.closeDeleteModal();

        try {
            const res = await fetch(`/admin/chat/message/${messageId}`, {
                method: 'DELETE',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ mode }),
            });

            const data = await res.json();

            if (data.status) {
                if (mode === 'me') {
                    // Remove the message bubble for "delete for me"
                    this.removeMessageBubble(messageId);
                }
                this.showNotification(data.message || 'Message deleted', 'success');
            } else {
                this.showNotification(data.error || 'Failed to delete message', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Delete error:', error);
            this.showNotification('Failed to delete message', 'error');
        }
    }

    removeMessageBubble(messageId) {
        const el = document.getElementById('msg-' + messageId);
        if (el) el.remove();
    }

    handleMessageDeleted(data) {
        if (!data || !data.id) return;

        // Show "This message was deleted" placeholder
        const el = document.getElementById('msg-' + data.id);
        if (!el) return;

        const isMe = el.classList.contains('items-end');
        el.innerHTML = `
            <div class="max-w-[85%] md:max-w-[70%] lg:max-w-[65%] ${isMe
                ? 'bg-[#f0f2f5] rounded-[8px_8px_0_8px]'
                : 'bg-[#f0f2f5] border border-[#e9edef] rounded-[0_8px_8px_8px]'
            } px-3.5 py-2 opacity-60">
                <div class="flex items-center gap-2 ${isMe ? 'justify-end' : 'justify-start'}">
                    <i class="fas fa-trash-alt text-xs text-[#8696a0]"></i>
                    <span class="text-xs italic text-[#8696a0]">This message was deleted</span>
                </div>
            </div>
        `;
    }

    handleMessageReacted(data) {
        if (!data || !data.message_id) return;
        this.optimisticReactionToggle(data.message_id, data.emoji, data.admin_id, data.action);
    }

    handleMemberKicked(data) {
        if (!data || !data.group_id) return;

        // If viewing this group, switch to no-chat
        if (parseInt(this.activeChatId) === parseInt(data.group_id) && this.activeChatType === 'group') {
            if (this.elements.chatArea) this.elements.chatArea.classList.add('hidden');
            if (this.elements.chatHeaderArea) this.elements.chatHeaderArea.classList.add('hidden');
            if (this.elements.noChat) this.elements.noChat.classList.remove('hidden');
            this.activeChatId = null;
            this.activeChatType = null;
        }

        // Unsubscribe from the group channel
        const chanName = `private-group-chat-${data.group_id}`;
        if (window.pusherInstance && this.subscribedChannels.has(chanName)) {
            try {
                window.pusherInstance.unsubscribe(chanName);
            } catch (e) {}
            this.subscribedChannels.delete(chanName);
        }

        // Refresh sidebar to remove the group
        if (window.sidebarManager) window.sidebarManager.refreshChatList();

        this.showNotification(
            data.group_deleted
                ? `Group "${data.group_name}" was deleted by admin`
                : data.group_name
                    ? `You were removed from "${data.group_name}"`
                    : 'You were removed from the group',
            'info'
        );
    }

    async toggleReaction(messageId, emoji) {
        // Optimistic UI update
        this.optimisticReactionToggle(messageId, emoji, window.currentAdminId);

        try {
            const res = await fetch(`/admin/chat/message/${messageId}/react`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ emoji }),
            });
            const data = await res.json();
            if (!data.status) {
                // Revert on failure
                this.optimisticReactionToggle(messageId, emoji, window.currentAdminId);
                this.showNotification(data.error || 'Failed to add reaction', 'error');
            }
        } catch (error) {
            this.optimisticReactionToggle(messageId, emoji, window.currentAdminId);
            console.error('[ChatManager] Reaction error:', error);
            this.showNotification('Failed to add reaction', 'error');
        }
    }

    optimisticReactionToggle(messageId, emoji, adminId, action = null) {
        const el = document.getElementById('msg-' + messageId);
        if (!el) return;

        const bar = el.querySelector('.reactions-bar');
        if (!bar) return;

        const existingBtn = bar.querySelector(`.reaction-btn[data-emoji="${emoji}"]`);
        const isMine = parseInt(adminId) === parseInt(window.currentAdminId);

        if (existingBtn) {
            const count = parseInt(existingBtn.dataset.count);
            const iAlreadyReacted = existingBtn.classList.contains('bg-[#d9fdd3]');

            const shouldRemove = action === 'removed' || (action === null && iAlreadyReacted);

            if (shouldRemove) {
                if (count <= 1) {
                    existingBtn.remove();
                } else {
                    existingBtn.dataset.count = count - 1;
                    const countEl = existingBtn.querySelector('.reaction-count');
                    if (countEl) countEl.textContent = count - 1;
                    if (isMine || action === null) {
                        existingBtn.classList.remove('bg-[#d9fdd3]', 'border-[#00a884]');
                        existingBtn.classList.add('bg-white', 'border-[#e9edef]');
                    }
                }
            } else {
                existingBtn.dataset.count = count + 1;
                const countEl = existingBtn.querySelector('.reaction-count');
                if (countEl) countEl.textContent = count + 1;
                if (isMine) {
                    existingBtn.classList.remove('bg-white', 'border-[#e9edef]');
                    existingBtn.classList.add('bg-[#d9fdd3]', 'border-[#00a884]');
                }
            }
        } else {
            const btn = document.createElement('button');
            btn.className = `reaction-btn inline-flex items-center gap-1 text-xs px-1.5 py-0.5 rounded-full border transition-all ${isMine ? 'bg-[#d9fdd3] border-[#00a884]' : 'bg-white border-[#e9edef] hover:bg-[#f0f2f5]'}`;
            btn.dataset.emoji = emoji;
            btn.dataset.count = '1';
            btn.onclick = () => window.chatManager?.toggleReaction(messageId, emoji);
            btn.innerHTML = `<span>${emoji}</span><span class="reaction-count font-medium">1</span>`;
            bar.appendChild(btn);
        }

        bar.classList.toggle('hidden', bar.querySelectorAll('.reaction-btn').length === 0);
    }

    toggleReactionPicker(messageId) {
        this.closeAllReactionPickers();
        const picker = document.getElementById('reaction-picker-' + messageId);
        if (picker) picker.classList.toggle('hidden');
    }

    closeAllReactionPickers() {
        document.querySelectorAll('.reaction-picker').forEach(el => el.classList.add('hidden'));
    }

    setupReactionPickerCloser() {
        if (this._reactionPickerSetup) return;
        this._reactionPickerSetup = true;

        document.addEventListener('click', (e) => {
            if (!e.target.closest('.reaction-picker') && !e.target.closest('.reaction-trigger')) {
                this.closeAllReactionPickers();
            }
        });
    }

    handleTyping() {
        if (!this.isTyping && this.activeChatId) {
            this.isTyping = true;
            this.broadcastTyping(true);
        }

        clearTimeout(this.typingTimer);
        this.typingTimer = setTimeout(() => {
            this.stopTyping();
        }, 2000);
    }

    stopTyping() {
        if (this.isTyping) {
            this.isTyping = false;
            this.broadcastTyping(false);
        }
        clearTimeout(this.typingTimer);
    }

    broadcastTyping(isTyping) {
        if (!this.activeChatId) return;

        fetch('/admin/chat/typing', {
            method: 'POST',
            headers: this.authHeaders({ 'Content-Type': 'application/json' }),
            body: JSON.stringify({
                chat_room_id: this.activeChatId,
                is_typing: isTyping,
                type: this.activeChatType,
            })
        });
    }

    handleUserTyping(data) {
        if (parseInt(data.user_id) === parseInt(window.currentAdminId)) return;

        // Only show typing indicator if the event is for the currently active chat
        if (parseInt(data.chat_room_id) !== parseInt(this.activeChatId)) return;

        if (data.is_typing) {
            if (this.elements.typingIndicator) this.elements.typingIndicator.classList.remove('hidden');
            if (this.elements.onlineStatus) this.elements.onlineStatus.classList.add('hidden');
        } else {
            if (this.elements.typingIndicator) this.elements.typingIndicator.classList.add('hidden');
            if (this.elements.onlineStatus) this.elements.onlineStatus.classList.remove('hidden');
        }
    }

    async markMessagesAsRead() {
        if (!this.activeChatId) return;

        try {
            await fetch(`/admin/chat/mark-read/${this.activeChatId}`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ chat_room_id: this.activeChatId }),
            });
        } catch (error) {
            console.error('[ChatManager] Error marking read:', error);
        }
    }

    async markMessageAsRead(messageId) {
        try {
            await fetch(`/admin/chat/message/${messageId}/read`, {
                method: 'POST',
                headers: this.authHeaders(),
            });
        } catch (error) {
            console.error('[ChatManager] Error marking message read:', error);
        }
    }

    updateMessageReadStatus(data) {
        if (!data.ids || !Array.isArray(data.ids)) return;
        data.ids.forEach(id => {
            const el = document.getElementById(`msg-status-${id}`);
            if (el) {
                el.textContent = '\u2713\u2713';
                el.classList.add('text-[#53bdeb]');
                el.classList.remove('text-[#8696a0]');
            }
        });
    }

    // Voice Recording
    toggleVoiceRecording() {
        if (this.isRecording) {
            this.stopRecording();
        } else {
            this.startRecording();
        }
    }

    stopRecording() {
        if (this.mediaRecorder && this.mediaRecorder.state !== 'inactive') {
            this.mediaRecorder.stop();
        }
        this.isRecording = false;
        clearInterval(this.recordingTimer);
        this.showRecordingUI(false);
    }

    cancelRecording() {
        if (this.mediaRecorder) {
            this.mediaRecorder.onstop = null;
            if (this.mediaRecorder.state !== 'inactive') {
                this.mediaRecorder.stop();
            }
            if (this.mediaRecorder.stream) {
                this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
            }
        }
        this.isRecording = false;
        clearInterval(this.recordingTimer);
        this.showRecordingUI(false);
        this.audioChunks = [];
    }

    showRecordingUI(show) {
        const ui = document.getElementById('voiceRecordingUI');
        const voiceBtn = document.getElementById('voiceBtn');
        if (ui) ui.classList.toggle('hidden', !show);
        if (voiceBtn) {
            voiceBtn.classList.toggle('bg-red-100', show);
            voiceBtn.classList.toggle('text-red-500', show);
        }
    }

    updateRecordingTime() {
        const elapsed = Math.floor((Date.now() - this.recordingStartTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        const timeEl = document.getElementById('recordingTime');
        if (timeEl) timeEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }

    async processVoiceRecording() {
        const blob = new Blob(this.audioChunks, { type: 'audio/webm' });
        const reader = new FileReader();

        // Optimistic placeholder
        const optimisticId = 'voice-' + Date.now();
        const placeholder = {
            id: optimisticId,
            message: '',
            type: 'audio',
            sender_id: parseInt(window.currentAdminId),
            created_at: new Date().toISOString(),
            is_optimistic: true,
        };
        this.addMessageToChat(placeholder, true);

        reader.onloadend = async () => {
            const base64data = reader.result.split(',')[1];

            try {
                const res = await fetch('/admin/chat/send-media', {
                    method: 'POST',
                    headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                    body: JSON.stringify({
                        audio_data: base64data,
                        chat_room_id: this.activeChatId,
                        type: this.activeChatType,
                    })
                });

                const data = await res.json();
                this.removeOptimisticMessage(optimisticId);
                if (data.status) {
                    this.addMessageToChat(data.message_data, true);
                    if (window.sidebarManager) window.sidebarManager.refreshChatList();
                } else {
                    this.showNotification('Failed to send voice message', 'error');
                }
            } catch (error) {
                this.removeOptimisticMessage(optimisticId);
                console.error('[ChatManager] Error sending voice:', error);
                this.showNotification('Failed to send voice message', 'error');
            }
        };

        reader.readAsDataURL(blob);
    }

    // Media Upload with image WebP compression
    handleMediaUpload(event) {
        const file = event.target.files?.[0];
        if (!file || !this.activeChatId) return;

        const isImage = file.type.startsWith('image/');
        const isVideo = file.type.startsWith('video/');
        const maxSize = 20 * 1024 * 1024; // 20MB

        if (file.size > maxSize) {
            this.showNotification('File too large (max 20MB)', 'error');
            event.target.value = '';
            return;
        }

        const processAndUpload = (processedFile) => {
            const formData = new FormData();
            formData.append('file', processedFile, processedFile.name);
            formData.append('chat_room_id', this.activeChatId);
            formData.append('type', this.activeChatType);

            // Optimistic placeholder
            const optimisticId = 'opt-' + Date.now();
            const placeholder = {
                id: optimisticId,
                message: isImage ? '/images/loading.jpg' : '',
                type: isImage ? 'image' : 'file',
                file_name: processedFile.name,
                sender_id: parseInt(window.currentAdminId),
                created_at: new Date().toISOString(),
                is_optimistic: true,
            };
            this.addMessageToChat(placeholder, true);

            fetch('/admin/chat/send-media', {
                method: 'POST',
                headers: this.authHeaders(),
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    this.removeOptimisticMessage(optimisticId);
                    if (data.status) {
                        this.addMessageToChat(data.message_data, true);
                        if (window.sidebarManager) window.sidebarManager.refreshChatList();
                    } else {
                        this.showNotification('Failed to upload media', 'error');
                    }
                })
                .catch(err => {
                    this.removeOptimisticMessage(optimisticId);
                    console.error('[ChatManager] Upload error:', err);
                    this.showNotification('Failed to upload media', 'error');
                });
        };

        if (isImage) {
            this.compressImage(file).then(blob => {
                const webpFile = new File([blob], file.name.replace(/\.[^.]+$/, '.webp'), { type: 'image/webp' });
                processAndUpload(webpFile);
            }).catch(() => {
                // Fallback: upload original
                processAndUpload(file);
            });
        } else {
            processAndUpload(file);
        }

        event.target.value = '';
    }

    // Compress image to WebP with max 1920px dimension
    compressImage(file) {
        return new Promise((resolve, reject) => {
            const img = new Image();
            const url = URL.createObjectURL(file);

            img.onload = () => {
                URL.revokeObjectURL(url);
                const maxDim = 1920;
                let { width, height } = img;

                if (width > maxDim || height > maxDim) {
                    const ratio = Math.min(maxDim / width, maxDim / height);
                    width = Math.round(width * ratio);
                    height = Math.round(height * ratio);
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob((blob) => {
                    if (blob) resolve(blob);
                    else reject(new Error('WebP conversion failed'));
                }, 'image/webp', 0.82);
            };

            img.onerror = () => {
                URL.revokeObjectURL(url);
                reject(new Error('Image load failed'));
            };

            img.src = url;
        });
    }

    // Voice recording with low bitrate Opus compression
    startRecording() {
        if (!this.activeChatId) {
            this.showNotification('Select a chat first', 'error');
            return;
        }

        navigator.mediaDevices.getUserMedia({ audio: true })
            .then(stream => {
                // Use low bitrate Opus for small file size
                this.mediaRecorder = new MediaRecorder(stream, {
                    mimeType: 'audio/webm;codecs=opus',
                    audioBitsPerSecond: 16000,
                });
                this.audioChunks = [];
                this.isRecording = true;

                this.mediaRecorder.ondataavailable = (event) => {
                    if (event.data.size > 0) this.audioChunks.push(event.data);
                };

                this.mediaRecorder.onstop = () => {
                    this.processVoiceRecording();
                    stream.getTracks().forEach(track => track.stop());
                };

                this.mediaRecorder.start();
                this.showRecordingUI(true);

                this.recordingStartTime = Date.now();
                this.recordingTimer = setInterval(() => {
                    this.updateRecordingTime();
                }, 1000);
            })
            .catch(err => {
                console.error('[ChatManager] Mic access denied:', err);
                this.showNotification('Microphone access denied', 'error');
            });
    }

    openChatInfoModal() {
        if (!this.activeChatId) return;

        const isGroup = this.activeChatType === 'group';
        const chatName = this.elements.chatName?.textContent || 'Chat';
        const chatAvatar = this.elements.chatAvatar?.src || '/images/default-avatar.png';
        const container = document.getElementById('chatInfoContent');

        if (container) {
            container.innerHTML = isGroup
                ? this.getGroupInfoContent(chatName, chatAvatar)
                : this.getPersonalInfoContent(chatName, chatAvatar);
        }

        const modal = document.getElementById('chatInfoModal');
        if (modal) modal.classList.remove('hidden');

        if (isGroup) {
            this.loadGroupMembers(this.activeChatId);
            this.loadGroupSettings(this.activeChatId);
        } else {
            this.loadBlockStatus();
        }
    }

    closeChatInfoModal() {
        const modal = document.getElementById('chatInfoModal');
        if (modal) modal.classList.add('hidden');
    }

    getGroupInfoContent(chatName, chatAvatar) {
        return `
            <div class="space-y-5">
                <div class="text-center">
                    <img src="${chatAvatar}" class="w-16 h-16 rounded-full mx-auto mb-2 border-2 border-white">
                    <h3 class="text-base font-semibold text-[#111b21]">${this.escapeHtml(chatName)}</h3>
                    <p class="text-xs text-[#667781] mt-0.5">Group Chat</p>
                </div>
                <div id="groupSendToggle">
                    <div class="text-center py-2 text-[#8696a0] text-xs">
                        <i class="fas fa-spinner fa-spin mr-1"></i> Loading settings...
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-medium text-[#111b21] mb-2 flex items-center">
                        <i class="fas fa-users mr-2 text-[#667781] text-xs"></i>
                        Group Members
                    </h4>
                    <div id="groupMembersList" class="space-y-1.5 max-h-60 overflow-y-auto border border-[#e9edef] rounded-lg p-2 bg-[#f0f2f5]">
                        <div class="text-center py-4 text-[#8696a0]">
                            <div class="animate-spin rounded-full h-4 w-4 border-2 border-[#e9edef] border-t-[#00a884] mx-auto mb-2"></div>
                            <p class="text-xs">Loading members...</p>
                        </div>
                    </div>
                    <div id="addMembersSection" class="mt-2 hidden"></div>
                </div>
                <div class="pt-4 border-t border-[#e9edef]">
                    <h4 class="text-sm font-medium text-[#111b21] mb-2 flex items-center">
                        <i class="fas fa-cog mr-2 text-[#667781] text-xs"></i>
                        Group Actions
                    </h4>
                    <div class="grid grid-cols-2 gap-2">
                        <button onclick="window.chatManager?.showClearChatOptions()"
                                class="py-2.5 bg-white text-[#111b21] rounded-lg border border-[#e9edef] hover:bg-[#f0f2f5] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-broom text-xs"></i>
                            <span>Clear Chat</span>
                        </button>
                        <button onclick="window.chatManager?.leaveGroup()"
                                class="py-2.5 bg-white text-[#ea0038] rounded-lg border border-[#e9edef] hover:bg-[#fef2f2] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-sign-out-alt text-xs"></i>
                            <span>Leave Group</span>
                        </button>
                    </div>
                    <div id="groupAdminActions" class="grid grid-cols-2 gap-2 mt-2 hidden">
                        <button onclick="window.chatManager?.openAddMembersModal()"
                                class="py-2.5 bg-[#00a884] text-white rounded-lg hover:bg-[#009977] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus text-xs"></i>
                            <span>Add Members</span>
                        </button>
                        <button onclick="window.chatManager?.deleteGroup()"
                                class="py-2.5 bg-[#ea0038] text-white rounded-lg hover:bg-[#d0002f] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-trash text-xs"></i>
                            <span>Delete Group</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    getPersonalInfoContent(chatName, chatAvatar) {
        return `
            <div class="space-y-5">
                <div class="text-center">
                    <img src="${chatAvatar}" class="w-16 h-16 rounded-full mx-auto mb-2 border-2 border-white" onerror="this.src='/images/default-avatar.png'">
                    <h3 class="text-base font-semibold text-[#111b21]">${this.escapeHtml(chatName)}</h3>
                    <p class="text-xs text-[#667781] mt-0.5 flex items-center justify-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-[#25d366] rounded-full inline-block"></span>
                        Online
                    </p>
                </div>
                <div class="pt-4 border-t border-[#e9edef]">
                    <h4 class="text-sm font-medium text-[#111b21] mb-2 flex items-center">
                        <i class="fas fa-cog mr-2 text-[#667781] text-xs"></i>
                        Chat Actions
                    </h4>
                    <div class="space-y-2">
                        <button onclick="window.chatManager?.showClearChatOptions()"
                                class="w-full py-2.5 bg-white text-[#111b21] rounded-lg border border-[#e9edef] hover:bg-[#f0f2f5] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-broom text-xs"></i>
                            <span>Clear Chat History</span>
                        </button>
                        <button id="blockContactBtn" onclick="window.chatManager?.toggleBlockContact()"
                                class="w-full py-2.5 bg-white text-[#ea0038] rounded-lg border border-[#e9edef] hover:bg-[#fef2f2] transition-colors text-sm font-medium flex items-center justify-center gap-2">
                            <i class="fas fa-ban text-xs"></i>
                            <span id="blockBtnText">Block Contact</span>
                        </button>
                    </div>
                </div>
                <div id="blockStatusMsg" class="hidden text-center text-xs text-[#8696a0]"></div>
            </div>
        `;
    }

    async loadGroupMembers(groupId) {
        const container = document.getElementById('groupMembersList');
        if (!container) return;

        try {
            const res = await fetch(`/admin/chat/group/${groupId}/members`);
            const data = await res.json();

            container.innerHTML = '';

            if (data.status && Array.isArray(data.data)) {
                data.data.forEach(member => {
                    const isMe = parseInt(member.id) === parseInt(window.currentAdminId);
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 p-2 bg-white rounded-lg border border-[#e9edef]';
                    div.innerHTML = `
                        <img src="${member.profile_pic || '/images/default-avatar.png'}"
                             class="w-8 h-8 rounded-full object-cover"
                             onerror="this.src='/images/default-avatar.png'">
                        <div class="flex-1 min-w-0">
                            <span class="text-sm font-medium text-[#111b21]">${this.escapeHtml(member.name)}</span>
                            ${member.is_creator ? '<span class="text-[10px] bg-[#d9fdd3] text-[#00a884] px-1.5 py-0.5 rounded ml-1.5 font-medium">Creator</span>' : ''}
                            ${isMe ? '<span class="text-[10px] bg-[#f0f2f5] text-[#667781] px-1.5 py-0.5 rounded ml-1.5 font-medium">You</span>' : ''}
                        </div>
                        ${member.can_kick && !isMe ? `
                            <button onclick="window.chatManager?.removeGroupMember(${groupId}, ${member.id})"
                                    class="w-7 h-7 rounded-lg bg-[#fef2f2] hover:bg-[#fee2e2] text-[#ea0038] flex items-center justify-center transition-colors text-xs"
                                    title="Remove ${this.escapeHtml(member.name)}">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : ''}
                    `;
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = '<div class="text-center py-4 text-slate-400 text-sm">No members found</div>';
            }
        } catch (error) {
            console.error('[ChatManager] Error loading members:', error);
            const container2 = document.getElementById('groupMembersList');
            if (container2) {
                container2.innerHTML = '<div class="text-center py-4 text-red-400 text-sm">Failed to load members</div>';
            }
        }
    }

    async removeGroupMember(groupId, memberId) {
        if (!confirm('Remove this member from the group?')) return;

        try {
            const res = await fetch(`/admin/chat/group/${groupId}/kick/${memberId}`, {
                method: 'POST',
                headers: this.authHeaders(),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification('Member removed', 'success');
                this.loadGroupMembers(groupId);
            } else {
                this.showNotification(data.error || 'Failed to remove member', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error removing member:', error);
            this.showNotification('Error removing member', 'error');
        }
    }

    async loadChatRestriction(groupId) {
        try {
            const res = await fetch(`/admin/chat/group/${groupId}/info`);
            const data = await res.json();

            if (data.status && this.activeChatId === groupId) {
                this.groupCreatedBy = parseInt(data.created_by);
                this.onlyAdminsCanSend = data.only_admins_can_send;
                this.isSuperAdmin = data.is_super_admin;
                this.updateSendRestrictionUI(data.only_admins_can_send);
            }
        } catch (error) {
            console.error('[ChatManager] Error loading chat restriction:', error);
        }
    }

    async openAddMembersModal() {
        if (!this.activeChatId) return;
        const container = document.getElementById('addMembersSection');
        if (!container) return;

        container.classList.remove('hidden');
        container.innerHTML = '<div class="text-center py-2 text-slate-400 text-xs"><i class="fas fa-spinner fa-spin mr-1"></i> Loading available admins...</div>';

        try {
            const res = await fetch(`/admin/chat/group/${this.activeChatId}/available-admins`);
            const admins = await res.json();

            if (!admins || !admins.length) {
                container.innerHTML = '<div class="text-center py-3 text-slate-400 text-xs border border-slate-200 rounded-lg bg-slate-50">No more admins available to add</div>';
                return;
            }

            container.innerHTML = `
                <div class="border border-[#e9edef] rounded-lg p-3 bg-[#f0f2f5] space-y-1.5">
                    <p class="text-xs font-medium text-[#111b21] mb-2 flex items-center gap-1.5">
                        <i class="fas fa-user-plus text-[#00a884]"></i>
                        Select admins to add
                    </p>
                    ${admins.map(a => `
                        <label class="flex items-center gap-2 p-2 bg-white rounded-lg border border-[#e9edef] cursor-pointer hover:bg-[#f0f2f5] transition-colors">
                            <input type="checkbox" class="add-member-cb rounded text-[#00a884] focus:ring-[#00a884]" value="${a.id}">
                            <img src="${a.profile_pic || '/images/default-avatar.png'}" class="w-6 h-6 rounded-full object-cover" onerror="this.src='/images/default-avatar.png'">
                            <span class="text-xs font-medium text-[#111b21]">${this.escapeHtml(a.name)}</span>
                            <span class="text-[10px] text-[#8696a0] ml-auto">${a.role || ''}</span>
                        </label>
                    `).join('')}
                    <button onclick="window.chatManager?.addSelectedMembers(${this.activeChatId})"
                            class="w-full mt-2 py-2 bg-[#00a884] text-white text-xs font-medium rounded-lg hover:bg-[#009977] transition-colors">
                        <i class="fas fa-plus mr-1"></i> Add Selected
                    </button>
                </div>
            `;
        } catch (error) {
            console.error('[ChatManager] Error loading available admins:', error);
            container.innerHTML = '<div class="text-center py-3 text-red-400 text-xs border border-red-200 rounded-lg bg-red-50">Failed to load admins</div>';
        }
    }

    async addSelectedMembers(groupId) {
        const cbs = document.querySelectorAll('.add-member-cb:checked');
        const memberIds = Array.from(cbs).map(cb => cb.value);

        if (!memberIds.length) {
            this.showNotification('Select at least one admin', 'error');
            return;
        }

        try {
            const res = await fetch(`/admin/chat/group/${groupId}/add-members`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ members: memberIds }),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification(data.message || 'Members added', 'success');
                document.getElementById('addMembersSection')?.classList.add('hidden');
                this.loadGroupMembers(groupId);
            } else {
                this.showNotification(data.error || 'Failed to add members', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error adding members:', error);
            this.showNotification('Failed to add members', 'error');
        }
    }

    async deleteGroup() {
        if (!this.activeChatId || this.activeChatType !== 'group') return;
        if (!confirm('Are you sure you want to permanently delete this group and all its messages? This action cannot be undone.')) return;

        try {
            const res = await fetch(`/admin/chat/group/${this.activeChatId}/delete`, {
                method: 'DELETE',
                headers: this.authHeaders(),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification('Group deleted successfully', 'success');
                this.closeChatInfoModal();

                // Switch to no-chat view
                if (this.elements.chatArea) this.elements.chatArea.classList.add('hidden');
                if (this.elements.chatHeaderArea) this.elements.chatHeaderArea.classList.add('hidden');
                if (this.elements.noChat) this.elements.noChat.classList.remove('hidden');
                this.activeChatId = null;
                this.activeChatType = null;

                // Unsubscribe from the group channel
                const chanName = `private-group-chat-${groupId}`;
                if (window.pusherInstance && this.subscribedChannels.has(chanName)) {
                    try { window.pusherInstance.unsubscribe(chanName); } catch (e) {}
                    this.subscribedChannels.delete(chanName);
                }

                if (window.sidebarManager) window.sidebarManager.refreshChatList();
            } else {
                this.showNotification(data.error || 'Failed to delete group', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error deleting group:', error);
            this.showNotification('Failed to delete group', 'error');
        }
    }

    async loadGroupSettings(groupId) {
        try {
            const res = await fetch(`/admin/chat/group/${groupId}/info`);
            const data = await res.json();

            if (data.status) {
                const isCreator = parseInt(data.created_by) === parseInt(window.currentAdminId);
                const canManage = data.is_super_admin || isCreator;

                // Show admin action buttons (Add Members, Delete Group)
                const adminActions = document.getElementById('groupAdminActions');
                if (adminActions) {
                    adminActions.classList.toggle('hidden', !canManage);
                }

                const toggleContainer = document.getElementById('groupSendToggle');
                if (toggleContainer) {
                    if (canManage) {
                        const isEnabled = data.only_admins_can_send;
                        toggleContainer.innerHTML = `
                            <label class="flex items-center justify-between p-3 bg-white rounded-lg border border-[#e9edef] cursor-pointer">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-[#667781]"></i>
                                    <div>
                                        <span class="text-sm font-medium text-[#111b21]">Only admins can send</span>
                                        <p class="text-xs text-[#8696a0]">Restrict messaging to group creator</p>
                                    </div>
                                </div>
                                <div class="relative inline-flex items-center cursor-pointer" onclick="event.stopPropagation()">
                                    <input type="checkbox" id="onlyAdminsSendToggle"
                                           class="sr-only peer"
                                           ${isEnabled ? 'checked' : ''}
                                           onchange="window.chatManager?.toggleOnlyAdminsSend(${groupId}, this.checked)">
                                    <div class="w-10 h-5 bg-[#e9edef] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#00a884]"></div>
                                </div>
                            </label>
                        `;
                    } else {
                        toggleContainer.innerHTML = `
                            <div class="flex items-center justify-between p-3 bg-[#f0f2f5] rounded-lg border border-[#e9edef]">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-shield-alt text-[#8696a0]"></i>
                                    <span class="text-sm text-[#667781]">Only admins can send</span>
                                </div>
                                <span class="text-xs ${data.only_admins_can_send ? 'text-[#00a884] font-medium' : 'text-[#8696a0]'}">${data.only_admins_can_send ? 'ON' : 'OFF'}</span>
                            </div>
                        `;
                    }
                }
            }
        } catch (error) {
            console.error('[ChatManager] Error loading group settings:', error);
        }
    }

    async toggleOnlyAdminsSend(groupId, enabled) {
        try {
            const res = await fetch(`/admin/chat/group/${groupId}/update`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({
                    name: document.getElementById('chatName')?.textContent || 'Group',
                    only_admins_can_send: enabled,
                }),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification(enabled ? 'Only admins can send' : 'All members can send', 'success');
                this.updateSendRestrictionUI(enabled);
            } else {
                this.showNotification(data.error || 'Failed to update setting', 'error');
                // Revert toggle
                const toggle = document.getElementById('onlyAdminsSendToggle');
                if (toggle) toggle.checked = !enabled;
            }
        } catch (error) {
            console.error('[ChatManager] Error toggling send restriction:', error);
            this.showNotification('Error updating setting', 'error');
            const toggle = document.getElementById('onlyAdminsSendToggle');
            if (toggle) toggle.checked = !enabled;
        }
    }

    updateSendRestrictionUI(enabled) {
        // Remove existing restriction bar first
        const oldBar = document.getElementById('sendRestrictBar');
        if (oldBar) oldBar.remove();

        if (this.activeChatType !== 'group' || !enabled) return;

        const isCreator = parseInt(this.groupCreatedBy) === parseInt(window.currentAdminId);
        const isExempt = isCreator || this.isSuperAdmin;

        let restrictBar = document.getElementById('sendRestrictBar');
        if (!restrictBar) {
            restrictBar = document.createElement('div');
            restrictBar.id = 'sendRestrictBar';
            restrictBar.className = 'text-center py-1.5 bg-[#fff8e5] text-xs text-[#667781] border-t border-[#e9edef]';
            restrictBar.innerHTML = isExempt
                ? '<i class="fas fa-shield-alt mr-1 text-[#00a884]"></i> <span class="text-[#00a884] font-medium">Only admins can send</span> — You are exempt'
                : '<i class="fas fa-shield-alt mr-1 text-[#667781]"></i> Only the group admin can send messages';
            const inputArea = document.querySelector('.chat-footer') || document.getElementById('sendMessageBtn')?.closest('.flex-shrink-0');
            if (inputArea) {
                inputArea.parentNode.insertBefore(restrictBar, inputArea);
            }
        }

        // Disable input for non-creator (respect network state)
        const actuallyEnabled = isExempt && this.isOnline;
        if (this.elements.messageInput) {
            this.elements.messageInput.disabled = !actuallyEnabled;
            this.elements.messageInput.placeholder = !this.isOnline
                ? 'Reconnecting...'
                : isExempt
                    ? 'Type a message...'
                    : 'Only the group admin can send messages';
        }

        const sendBtn = document.getElementById('sendMessageBtn');
        if (sendBtn) {
            sendBtn.disabled = !actuallyEnabled;
            sendBtn.classList.toggle('opacity-50', !actuallyEnabled);
            sendBtn.classList.toggle('cursor-not-allowed', !actuallyEnabled);
        }

        const voiceBtn = document.getElementById('voiceBtn');
        if (voiceBtn) {
            voiceBtn.disabled = !actuallyEnabled;
            voiceBtn.classList.toggle('opacity-50', !actuallyEnabled);
            voiceBtn.classList.toggle('cursor-not-allowed', !actuallyEnabled);
        }

        const mediaBtn = document.getElementById('mediaUploadBtn');
        if (mediaBtn) {
            mediaBtn.disabled = !actuallyEnabled;
            mediaBtn.classList.toggle('opacity-50', !actuallyEnabled);
            mediaBtn.classList.toggle('cursor-not-allowed', !actuallyEnabled);
        }
    }

    showClearChatOptions() {
        if (!this.activeChatId) return;

        const isGroup = this.activeChatType === 'group';
        const message = isGroup
            ? 'Clear all messages in this group?'
            : 'Clear all messages in this conversation?';

        if (!confirm(message + ' Choose OK for "Delete for me", Cancel to go back.')) return;

        // Simple confirm-based approach for "delete for me"
        this.clearChat('me');
    }

    async clearChat(mode = 'me') {
        if (!this.activeChatId) return;

        try {
            const res = await fetch(`/admin/chat/clear/${this.activeChatId}`, {
                method: 'POST',
                headers: this.authHeaders({ 'Content-Type': 'application/json' }),
                body: JSON.stringify({ mode }),
            });

            const data = await res.json();

            if (data.status) {
                if (this.elements.messageContainer) {
                    this.elements.messageContainer.innerHTML = `
                        <div class="text-center py-16">
                            <i class="fas fa-broom text-2xl text-[#8696a0] mb-2"></i>
                            <p class="text-sm text-[#667781]">${this.escapeHtml(data.message || 'Chat cleared')}</p>
                        </div>
                    `;
                }
                this.showNotification(data.message || 'Chat cleared', 'success');
                this.closeChatInfoModal();
            } else {
                this.showNotification(data.error || 'Failed to clear chat', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error clearing chat:', error);
            this.showNotification('Error clearing chat', 'error');
        }
    }

    async loadBlockStatus() {
        if (!this.activeChatReceiverId) return;

        try {
            const res = await fetch(`/admin/chat/block-status/${this.activeChatReceiverId}`);
            const data = await res.json();

            if (data.status) {
                const btn = document.getElementById('blockContactBtn');
                const btnText = document.getElementById('blockBtnText');
                const statusMsg = document.getElementById('blockStatusMsg');

                if (data.i_blocked_them) {
                    if (btnText) btnText.textContent = 'Unblock Contact';
                    if (btn) {
                        btn.className = 'w-full py-2.5 bg-white text-[#667781] rounded-lg border border-[#e9edef] hover:bg-[#f0f2f5] transition-colors text-sm font-medium flex items-center justify-center gap-2';
                        btn.innerHTML = '<i class="fas fa-ban text-xs"></i><span id="blockBtnText">Unblock Contact</span>';
                    }
                    if (statusMsg) {
                        statusMsg.textContent = 'You have blocked this contact';
                        statusMsg.classList.remove('hidden');
                    }
                } else if (data.they_blocked_me) {
                    if (btn) btn.classList.add('hidden');
                    if (statusMsg) {
                        statusMsg.textContent = 'This contact has blocked you';
                        statusMsg.classList.remove('hidden');
                    }
                } else {
                    if (btnText) btnText.textContent = 'Block Contact';
                    if (btn) {
                        btn.className = 'w-full py-2.5 bg-white text-[#ea0038] rounded-lg border border-[#e9edef] hover:bg-[#fef2f2] transition-colors text-sm font-medium flex items-center justify-center gap-2';
                        btn.innerHTML = '<i class="fas fa-ban text-xs"></i><span id="blockBtnText">Block Contact</span>';
                    }
                    if (statusMsg) statusMsg.classList.add('hidden');
                }
            }
        } catch (error) {
            console.error('[ChatManager] Error loading block status:', error);
        }
    }

    async toggleBlockContact() {
        if (!this.activeChatReceiverId) return;

        const btnText = document.getElementById('blockBtnText');
        const isBlocked = btnText?.textContent === 'Unblock Contact';

        try {
            const endpoint = isBlocked ? 'unblock-contact' : 'block-contact';
            const res = await fetch(`/admin/chat/${endpoint}/${this.activeChatReceiverId}`, {
                method: 'POST',
                headers: this.authHeaders(),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification(data.message, 'success');
                this.loadBlockStatus();
            } else {
                this.showNotification(data.error || 'Failed to update block status', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error toggling block:', error);
            this.showNotification('Error updating block status', 'error');
        }
    }

    async leaveGroup() {
        if (!this.activeChatId || this.activeChatType !== 'group') return;
        if (!confirm('Are you sure you want to leave this group?')) return;

        try {
            const res = await fetch(`/admin/chat/group/${this.activeChatId}/leave`, {
                method: 'POST',
                headers: this.authHeaders(),
            });

            const data = await res.json();

            if (data.status) {
                this.showNotification('You have left the group', 'success');
                this.closeChatInfoModal();

                if (this.elements.chatArea) this.elements.chatArea.classList.add('hidden');
                if (this.elements.chatHeaderArea) this.elements.chatHeaderArea.classList.add('hidden');
                if (this.elements.noChat) this.elements.noChat.classList.remove('hidden');

                this.activeChatId = null;

                if (window.sidebarManager) window.sidebarManager.refreshChatList();
            } else {
                this.showNotification('Failed to leave group', 'error');
            }
        } catch (error) {
            console.error('[ChatManager] Error leaving group:', error);
            this.showNotification('Error leaving group', 'error');
        }
    }

    toggleChatMenu() {
        this.showNotification('Chat menu toggled', 'info');
    }

    goBackToSidebar() {
        if (window.innerWidth < 1024) {
            const sidebar = document.getElementById('chatSidebar');
            if (sidebar) sidebar.classList.remove('hidden');
            if (this.elements.chatArea) this.elements.chatArea.classList.add('hidden');
            if (this.elements.noChat) this.elements.noChat.classList.remove('hidden');
            if (this.elements.chatHeaderArea) this.elements.chatHeaderArea.classList.add('hidden');
            this.activeChatId = null;
        }
    }

    // UI Helpers
    showLoadingState() {
        if (this.elements.messageContainer) {
            this.elements.messageContainer.innerHTML = `
                <div class="flex justify-center items-center py-8">
                    <div class="animate-spin rounded-full h-6 w-6 border-2 border-[#e9edef] border-t-[#00a884]"></div>
                    <span class="ml-2 text-sm text-[#667781]">Loading messages...</span>
                </div>
            `;
        }
    }

    showEmptyState(show) {
        if (show && this.elements.messageContainer) {
            this.elements.messageContainer.innerHTML = `
                <div class="text-center py-12">
                    <div class="w-14 h-14 bg-[#f0f2f5] rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-comments text-xl text-[#8696a0]"></i>
                    </div>
                    <p class="text-sm font-medium text-[#667781]">No messages yet</p>
                    <p class="text-xs text-[#8696a0] mt-1">Start a conversation by sending a message!</p>
                </div>
            `;
        }
    }

    showErrorState(message) {
        if (this.elements.messageContainer) {
            this.elements.messageContainer.innerHTML = `
                <div class="text-center py-8">
                    <i class="fas fa-exclamation-triangle text-xl text-[#8696a0] mb-2"></i>
                    <p class="text-sm text-[#667781]">${message}</p>
                </div>
            `;
        }
    }

    scrollToBottom() {
        setTimeout(() => {
            if (this.elements.messageContainer) {
                this.elements.messageContainer.scrollTop = this.elements.messageContainer.scrollHeight;
            }
        }, 100);
    }

    showNotification(message, type = 'info') {
        const colors = { error: 'bg-[#ea0038]', success: 'bg-[#00a884]', info: 'bg-[#54656f]' };
        const icons = { error: 'fa-exclamation-triangle', success: 'fa-check-circle', info: 'fa-info-circle' };

        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-4 py-2.5 rounded-lg shadow-lg z-50 flex items-center gap-2 text-sm font-medium`;
        notification.innerHTML = `<i class="fas ${icons[type]} text-xs"></i><span>${message}</span>`;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) notification.remove();
        }, 3000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    highlightMentions(text) {
        return this.escapeHtml(text || '').replace(/@(\S+)/g, '<span class="text-[#00a884] font-medium">@$1</span>');
    }
}

export default ChatManager;