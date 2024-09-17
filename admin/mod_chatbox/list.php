<style>
    .chat-messages {
    flex: 1;
    padding: 20px;
    background-color: #f8f9fa;
    overflow-y: auto;
}

.message {
    display: flex;
    margin-bottom: 15px;
}

.message.sent {
    justify-content: flex-end;
}

.message .content {
    display: inline-block; /* Ensure it only takes up as much space as the text */
    max-width: 60%; /* Set a max width so long messages wrap */
    padding: 10px;
    border-radius: 10px;
    background-color: #007bff;
    color: white;
    word-wrap: break-word; /* Ensure long words are wrapped */
}

.message.sent .content {
    background-color: #495057;
}

.message-form {
    padding: 10px;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
}

.message-form input {
    flex: 1;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.message-form button {
    margin-left: 10px;
}

</style>
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="display: flex; align-items: center;">
            <h6 class="m-0 font-weight-bold text-primary">Chat List</h6>
            <div style="display: flex; width: 100%; justify-content: flex-end;">
                <!-- You can add additional buttons or actions here -->
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Column 1: Chat List -->
                <div class="col-md-4">
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action active">John Doe</a>
                        <a href="#" class="list-group-item list-group-item-action">Jane Smith</a>
                        <a href="#" class="list-group-item list-group-item-action">David Johnson</a>
                        <a href="#" class="list-group-item list-group-item-action">Emily Davis</a>
                    </div>
                </div>

                <!-- Column 2: Chat Area -->
                <div class="col-md-8">
                    <div class="chat-area" style="border: 1px solid #ddd; border-radius: 5px; padding: 15px;">
                        <div class="chat-header" style="font-size: 16px; font-weight: bold; margin-bottom: 10px;">
                            Chat with John Doe
                        </div>

                        <div class="chat-messages" style="height: 300px; overflow-y: auto; border-bottom: 1px solid #ddd; padding-bottom: 15px; margin-bottom: 15px;">
                            <div class="message" style="margin-bottom: 10px;">
                                <div class="content" style="background-color: #007bff; color: white; padding: 10px; border-radius: 10px;">
                                    Hello, how are you?
                                </div>
                            </div>
                            <div class="message sent" style="text-align: right; margin-bottom: 10px;">
                                <div class="content" style="background-color: #495057; color: white; padding: 10px; border-radius: 10px;">
                                    I am good, thank you!
                                </div>
                            </div>
                        </div>

                        <div class="message-form" style="display: flex; align-items: center;">
                            <input type="text" class="form-control" placeholder="Type a message...">
                            <button class="btn btn-primary" style="margin-left: 10px;"><i class="fa fa-paper-plane"></i></button>
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