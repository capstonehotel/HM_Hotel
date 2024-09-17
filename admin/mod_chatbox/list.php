<style>
  .chat-window {
    display: flex;
    height: 100%;
}

.chat-cont-left, .chat-cont-right {
    flex: 1;
}

.chat-users-list {
    border-right: 1px solid #ddd;
    height: 100%;
}

.media {
    display: flex;
    align-items: center;
    padding: 10px;
}

.media-img-wrap {
    margin-right: 10px;
}

.avatar {
    border-radius: 50%;
}

.chat-body {
    display: flex;
    flex-direction: column;
}

.msg-box {
    display: inline-block;
    padding: 10px;
    border-radius: 10px;
}

.chat-footer {
    border-top: 1px solid #ddd;
    padding: 10px;
}

.input-msg-send {
    flex: 1;
}

</style>
<div class="container-fluid mt-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Chats</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <!-- You can add additional buttons or actions here -->
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Column 1: Chat List -->
                <div class="col-md-4">
                    <div class="chat-users-list">
                        <div class="chat-scroll">
                            <a href="javascript:void(0);" class="media">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-away">
                                        <img src="assets/img/profiles/avatar-03.jpg" alt="User Image" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="user-name">Justin Lee</div>
                                        <div class="user-last-chat">Hey, How are you?</div>
                                    </div>
                                    <div>
                                        <div class="last-chat-time block">2 min</div>
                                        <div class="badge badge-success badge-pill">15</div>
                                    </div>
                                </div>
                            </a>
                            <a href="javascript:void(0);" class="media read-chat active">
                                <div class="media-img-wrap">
                                    <div class="avatar avatar-online">
                                        <img src="assets/img/profiles/avatar-04.jpg" alt="User Image" class="avatar-img rounded-circle">
                                    </div>
                                </div>
                                <div class="media-body">
                                    <div>
                                        <div class="user-name">Joe Edwards</div>
                                        <div class="user-last-chat">I'll call you later</div>
                                    </div>
                                    <div>
                                        <div class="last-chat-time block">8:01 PM</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Column 2: Chat Area -->
                <div class="col-md-8">
                    <div class="chat-area" style="border: 1px solid #ddd; border-radius: 5px; padding: 15px;">
                        <div class="chat-header" style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                            Chat with John Doe
                        </div>
                        <div class="chat-body" style="height: 300px; overflow-y: auto; border-bottom: 1px solid #ddd; padding-bottom: 15px; margin-bottom: 15px;">
                            <!-- Messages -->
                            <ul class="list-unstyled">
                                <li class="media sent">
                                    <div class="media-body">
                                        <div class="msg-box" style="background-color: #007bff; color: white; padding: 10px; border-radius: 10px;">
                                            <p>Hello. What can I do for you?</p>
                                            <ul class="chat-msg-info">
                                                <li>
                                                    <div class="chat-time"> <span>8:30 AM</span> </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="media received">
                                    <div class="avatar">
                                        <img src="assets/img/profiles/avatar-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                    </div>
                                    <div class="media-body">
                                        <div class="msg-box" style="background-color: #495057; color: white; padding: 10px; border-radius: 10px;">
                                            <p>I'm just looking around.</p>
                                            <p>Will you tell me something about yourself?</p>
                                            <ul class="chat-msg-info">
                                                <li>
                                                    <div class="chat-time"> <span>8:35 AM</span> </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- Add more messages here as needed -->
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="chat-footer" style="display: flex; align-items: center;">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="btn-file btn">
                                        <i class="fas fa-paperclip" aria-hidden="true"></i>
                                        <input type="file">
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Type something">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Wait until the DOM is fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Get the necessary elements
    const messageForm = document.querySelector(".message-form");
    const messageInput = messageForm.querySelector("input");
    const messageSendButton = messageForm.querySelector("button");
    const chatMessages = document.querySelector(".chat-messages");

    // Function to add a new message to the chat
    function addMessage(content, isSent) {
        // Create message container
        const messageDiv = document.createElement("div");
        messageDiv.classList.add("message");
        if (isSent) {
            messageDiv.classList.add("sent");
        }

        // Create content bubble
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");
        contentDiv.textContent = content;

        // Append content to message container
        messageDiv.appendChild(contentDiv);

        // Append message to chat messages
        chatMessages.appendChild(messageDiv);

        // Scroll to the bottom of the chat
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Send button click event listener
    messageSendButton.addEventListener("click", function() {
        // Get the input text
        const messageText = messageInput.value.trim();

        // Only add the message if the input is not empty
        if (messageText !== "") {
            // Add sent message to the chat
            addMessage(messageText, true);

            // Clear the input field after sending
            messageInput.value = "";
        }
    });

    // Optionally, send message on pressing 'Enter' key
    messageInput.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            messageSendButton.click();
        }
    });
});

</script>

