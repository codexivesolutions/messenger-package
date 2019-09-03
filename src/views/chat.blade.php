
<!------ Include the above in your HEAD tag ---------->


<!DOCTYPE html><html class=''>
<head>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>
    <link rel="stylesheet" type="text/css" href="{{asset('msgCss/main.css')}}">
    <style>
        .sender{
            display: inline-block;
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 205px;
            line-height: 130%;
            background: #435f7a;
            color: #f5f5f5;
        }
        .receiver{
            display: inline-block;
            padding: 10px 15px;
            border-radius: 20px;
            max-width: 205px;
            line-height: 130%;
            background: white;
            color: black;
        }
    </style>
</head>
<body>
@php
    use App\User;
    use App\helpers\CommonHelper;
    $ses = auth()->user();   
@endphp
<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<img id="profile-img" src="http://emilcarlsson.se/assets/mikeross.png" class="online" alt="" />
				<p>{{ $ses->name }}</p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>
				<div id="expanded">
					<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mikeross" />
					<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="ross81" />
					<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mike.ross" />
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." />
		</div>
		<div id="contacts">
			<ul>
                @php
                    $ses = auth()->user();    
                @endphp
                @foreach ($users as $user)
                    @if ($user->email !== $ses->email)
                        <li class="contact">
                            <a href="javascript:void(0);" id="{{$user->id}}" class="msg" style="text-decoration: none;color: white;">
                                <div class="wrap">
                                    <span class="contact-status online"></span>
                                    <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                                    <div class="meta">
                                        <p class="name">{{ $user->name }}</p>
                                        @php
                                            $userData = User::find($user->id);
                                            $msg = CommonHelper::last_noty($user->id);   
                                            $Cmsg = $userData->unreadNotifications->count(); 
                                        @endphp
                                        <p class="preview">{{ ($msg == '') ? '' : $msg->data['msg'] }} </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endif
                @endforeach  
                <li class="contact">
                    <a href="javascript:void(0);"  class="groupMsg" style="text-decoration: none;color: white;">
                        <div class="wrap">
                            <span class="contact-status online"></span>
                            <img src="http://emilcarlsson.se/assets/louislitt.png" alt="" />
                            <div class="meta">
                                <p class="name">Group Chat</p>
                                <p class="preview"> GroupMessage between User </p>
                            </div>
                        </div>
                    </a>
                </li>
			</ul>
		</div>
		<div id="bottom-bar">
			<button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Add contact</span></button>
			<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
			<img src="http://emilcarlsson.se/assets/harveyspecter.png" alt="" />
			<p id="receiver_name"></p>
			<div class="social-media">
				<i class="fa fa-facebook" aria-hidden="true"></i>
				<i class="fa fa-twitter" aria-hidden="true"></i>
				 <i class="fa fa-instagram" aria-hidden="true"></i>
			</div>
		</div>
		<div class="messages" >
			<ul id="msgcon">
                <img src="{{asset('msgCss/send.JPG')}}">
			</ul>
		</div>
		<div class="message-input">
			<div class="wrap">
                <input type="hidden" name="type" id="type" value="single">
                <input type="hidden" name="receiver_id" id="receiver_id">    
                <input type="text" placeholder="Write your message..." name="msg" id="msg"/>
                <i class="fa fa-paperclip attachment" aria-hidden="true"></i>
                <button class="send"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function(){
        $('.msg').click(function(){
            $(this).parent().addClass('active');
            $(this).blur(function(){
                $(this).parent().removeClass('active');
            });
            var receiver_id = $(this).attr('id');
            $('#receiver_id').val(receiver_id);
            $('#type').val('single');
            var type = $('#type').val();
            $.ajax({
               type: 'POST',
               url: "{!!url('/get_message')!!}",
               data: {
                   "_token": '{{ csrf_token() }}',
                   receiver_id: receiver_id,
                   type: type
               },
               success: function(data) {
                $('#msgcon').html(data);
               }
           });
        });

        $('.groupMsg').click(function(){
            $(this).parent().addClass('active');
            $(this).blur(function(){
                $(this).parent().removeClass('active');
            });
             $('#type').val('group');
             var type = $('#type').val();
            $.ajax({
               type: 'POST',
               url: "{!!url('/get_message')!!}",
               data: {
                   "_token": '{{ csrf_token() }}',
                   type: type
               },
               success: function(data) {
                $('#msgcon').html(data);
                $('#receiver_name').html('Group Chat');
               }
           });
        });

        $('.send').click(function(){
            var type = $('#type').val();
            var receiver_id = $('#receiver_id').val();
            var msg = $('#msg').val();
            $.ajax({
            type: 'POST',
            url: "{!!url('/messages')!!}",
            data: {
                "_token": '{{ csrf_token() }}',
                receiver_id: receiver_id,
                msg: msg,
                type: type
            },
            success: function(data) {
            $('#msgcon').html(data);
            }
        });
        $('#msg').val('');
        });

    $('.msg').click(function(){
        clearInterval(group);
        var group = setInterval(function(){
            var receiver_id = $('#receiver_id').val();
                $('#type').val('single');
                var type = $('#type').val();
                $.ajax({
                type: 'POST',
                url: "{!!url('/get_message')!!}",
                data: {
                    "_token": '{{ csrf_token() }}',
                    receiver_id: receiver_id,
                    type: type
                },
                success: function(data) {
                    $('#msgcon').html(data);
                }
            });
            },1000);
    });   
    $('.groupMsg').click(function(){
       clearInterval(single); 
       var group = setInterval(function() {
            $('#type').val('group');
             var type = $('#type').val();
            $.ajax({
               type: 'POST',
               url: "{!!url('/get_message')!!}",
               data: {
                   "_token": '{{ csrf_token() }}',
                   type: type
               },
               success: function(data) {
                $('#msgcon').html(data);
               }
           });
        }, 5000);
    }); 
    $('.msg').click(function(){
        var receiver_id = $('#receiver_id').val();
        $.ajax({
               type: 'POST',
               url: "{!!url('/receiver_name')!!}",
               data: {
                   "_token": '{{ csrf_token() }}',
                   receiver_id: receiver_id
               },
               success: function(data) {
                   var receiver_name = JSON.parse(data);
                $('#receiver_name').text(receiver_name);
               }
           });
    });  
    });
</script>
</body>
</html>