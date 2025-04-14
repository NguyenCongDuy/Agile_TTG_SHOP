const ChatUI = {
    typeWriter(element, text, speed = 30) {
        let i = 0;
        element.innerHTML = '';
        const lines = text.split('\n');
        let currentLine = 0;
        
        function type() {
            if (currentLine < lines.length) {
                if (i < lines[currentLine].length) {
                    element.innerHTML = element.innerHTML.slice(0, -4) + lines[currentLine].charAt(i) + '<br>';
                    i++;
                    setTimeout(type, speed);
                } else {
                    element.innerHTML += '<br>';
                    currentLine++;
                    i = 0;
                    setTimeout(type, speed * 2);
                }
                ChatUI.scrollToBottom();
            }
        }
        type();
    },

    createMessage(content, type) {
        const div = document.createElement('div');
        div.className = `message ${type}-message d-flex`;
        
        const iconDiv = document.createElement('div');
        iconDiv.className = `message-icon ${type}-icon`;
        iconDiv.innerHTML = `<i class="fas fa-${type === 'user' ? 'user' : 'robot'}"></i>`;
        
        const contentDiv = document.createElement('div');
        contentDiv.className = 'flex-grow-1 whitespace-pre-wrap';
        contentDiv.innerHTML = content + '<br>';
        
        div.appendChild(iconDiv);
        div.appendChild(contentDiv);
        
        return div;
    },

    showLoading(element) {
        let loadingDots = 0;
        return setInterval(() => {
            element.innerHTML = '.'.repeat(loadingDots + 1);
            loadingDots = (loadingDots + 1) % 3;
        }, 500);
    },

    scrollToBottom() {
        window.scrollTo(0, document.body.scrollHeight);
    },

    initTextarea() {
        const textarea = document.querySelector('textarea');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
};