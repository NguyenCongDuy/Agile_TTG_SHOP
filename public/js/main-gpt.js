async function submitQuestion(event) {
    event.preventDefault();
    
    const form = event.target;
    const input = form.querySelector('#questionInput');
    const button = form.querySelector('#submitButton');
    const question = input.value;
    
    if (!question.trim()) return;

    // Disable input và button
    input.disabled = true;
    button.disabled = true;

    // Thêm tin nhắn người dùng
    const messagesContainer = document.getElementById('messages');
    const userMessage = ChatUI.createMessage(question, 'user');
    messagesContainer.appendChild(userMessage);
    
    // Thêm placeholder cho câu trả lời AI
    const aiMessage = ChatUI.createMessage('', 'ai');
    messagesContainer.appendChild(aiMessage);
    const aiMessageContent = aiMessage.querySelector('.flex-grow-1');
    
    // Hiển thị loading
    const loadingInterval = ChatUI.showLoading(aiMessageContent);
    ChatUI.scrollToBottom();

    try {
        const data = await ChatAPI.sendQuestion(question);
        clearInterval(loadingInterval);
        
        if (data.success) {
            ChatUI.typeWriter(aiMessageContent, data.answer);
        } else {
            ChatUI.typeWriter(aiMessageContent, 'Xin lỗi, đã có lỗi xảy ra.');
        }
    } catch (error) {
        clearInterval(loadingInterval);
        ChatUI.typeWriter(aiMessageContent, 'Xin lỗi, đã có lỗi xảy ra.');
    } finally {
        input.disabled = false;
        button.disabled = false;
        input.value = '';
        input.style.height = 'auto';
    }
}

// Initialize
ChatUI.initTextarea();