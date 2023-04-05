<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        .avatar {
            vertical-align: middle;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
</head>

<body>

    <h2><img src="https://pbs.twimg.com/profile_images/1339213145492115459/QGPRk1-2_normal.jpg" style="width:70px;height:70px" alt="Avatar" class="avatar"> C4eTech Links</h2>

    <div style="width: 45%;">
        @foreach ($users_data as $data)
            <img src="{{ $data->image }}" alt="Avatar" class="avatar">
        @endforeach
    </div>
</body>

</html>
