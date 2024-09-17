
<style>
    .chat-list-header {
        font-size: 18px;
        font-weight: bold;
        border-bottom: 1px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 10px;
    }

    .chat-area {
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .chat-messages {
        flex: 1;
        padding: 20px;
        background-color: #f8f9fa;
        overflow-y: auto;
        height: 300px; /* Adjust height as needed */
        border-bottom: 1px solid #ddd;
    }

    .message {
        display: flex;
        margin-bottom: 15px;
    }

    .message.sent {
        justify-content: flex-end;
    }

    .message .content {
        display: inline-block;
        max-width: 60%;
        padding: 10px;
        border-radius: 10px;
        background-color: #007bff;
        color: white;
        word-wrap: break-word;
    }

    .message.sent .content {
        background-color: #495057;
    }

    .message-form {
        padding: 10px;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        border-top: 1px solid #ddd;
    }

    .message-form input {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 5px;
        margin-right: 10px;
    }

    .message-form button {
        margin-left: 10px;
    }
</style>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="row">
            <!-- Column 1: Chat List -->
            <div class="col-md-4">
                <div class="chat-list-header">
                    Chats
                </div>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">John Doe</a>
                    <a href="#" class="list-group-item list-group-item-action">Jane Smith</a>
                    <a href="#" class="list-group-item list-group-item-action">David Johnson</a>
                    <a href="#" class="list-group-item list-group-item-action">Emily Davis</a>
                </div>
            </div>

            <!-- Column 2: Chat Area -->
            <div class="col-md-8">
                <div class="chat-area">
                    <div class="chat-header">
                        Chat with John Doe
                    </div>

                    <div class="chat-messages">
                        <div class="message">
                            <div class="content">
                                Hello, how are you?
                            </div>
                        </div>
                        <div class="message sent">
                            <div class="content">
                                I am good, thank you!
                            </div>
                        </div>
                    </div>

                    <div class="message-form">
                        <input type="text" class="form-control" placeholder="Type a message...">
                        <button class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    // Wait until the DOM is fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        const messageForm = document.querySelector(".message-form");
        const messageInput = messageForm.querySelector("input");
        const messageSendButton = messageForm.querySelector("button");
        const chatMessages = document.querySelector(".chat-messages");

        function addMessage(content, isSent) {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message");
            if (isSent) {
                messageDiv.classList.add("sent");
            }

            const contentDiv = document.createElement("div");
            contentDiv.classList.add("content");
            contentDiv.textContent = content;

            messageDiv.appendChild(contentDiv);
            chatMessages.appendChild(messageDiv);

            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        messageSendButton.addEventListener("click", function() {
            const messageText = messageInput.value.trim();

            if (messageText !== "") {
                addMessage(messageText, true);
                messageInput.value = "";
            }
        });

        messageInput.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                messageSendButton.click();
            }
        });
    });
</script>
