<style>
    .chat-users-list {
    max-height: 400px;
    overflow-y: auto;
}

.chat-scroll {
    padding: 10px;
}

.media {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.media:hover {
    background-color: #f1f1f1;
}

.chat-body {
    max-height: 400px;
    overflow-y: auto;
}

.msg-box {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 10px;
    margin-bottom: 10px;
}

.sent .msg-box {
    background-color: #007bff;
    color: white;
}

.received .msg-box {
    background-color: #e9ecef;
}

</style>
<div class="container-fluid">
    <div class="row mt-5">
        <!-- Chat User List Section -->
        <div class="col-md-4 chat-cont-left">
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="display: flex; justify-content: space-between;">
                    <h6 class="m-0 font-weight-bold text-primary">Chats</h6>
                    <a href="javascript:void(0)" class="chat-compose">
                        <i class="material-icons">control_point</i>
                    </a>
                </div>
                <div class="chat-search">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </div>
                <div class="chat-users-list">
                    <div class="chat-scroll">
                        <a href="javascript:void(0);" class="media">
                            <div class="media-img-wrap">
                                <div class="avatar avatar-away">
                                    <img src="assets/img/profiles/avatar-03.jpg" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="media-body">
                                <div class="user-name">Justin Lee</div>
                                <div class="user-last-chat">Hey, How are you?</div>
                            </div>
                            <div class="last-chat-time block">2 min</div>
                        </a>
                        <!-- Additional chat users here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Window Section -->
        <div class="col-md-8 chat-cont-right">
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="display: flex; justify-content: space-between;">
                    <div class="media">
                        <div class="media-img-wrap">
                            <div class="avatar avatar-online">
                                <img src="assets/img/profiles/avatar-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="user-name">John Doe</div>
                            <div class="user-status">online</div>
                        </div>
                    </div>
                    <div class="chat-options">
                        <a href="javascript:void(0)">
                            <i class="material-icons">local_phone</i>
                        </a>
                        <a href="javascript:void(0)">
                            <i class="material-icons">videocam</i>
                        </a>
                        <a href="javascript:void(0)">
                            <i class="material-icons">more_vert</i>
                        </a>
                    </div>
                </div>

                <div class="chat-body">
                    <div class="chat-scroll">
                        <ul class="list-unstyled">
                            <li class="media sent">
                                <div class="media-body">
                                    <div class="msg-box">
                                        <p>Hello. What can I do for you?</p>
                                        <div class="chat-time"> <span>8:30 AM</span> </div>
                                    </div>
                                </div>
                            </li>
                            <li class="media received">
                                <div class="avatar">
                                    <img src="assets/img/profiles/avatar-02.jpg" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="media-body">
                                    <div class="msg-box">
                                        <p>I'm just looking around.</p>
                                        <div class="chat-time"> <span>8:35 AM</span> </div>
                                    </div>
                                </div>
                            </li>
                            <!-- Additional chat messages here -->
                        </ul>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type a message">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
