<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GitHub</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- Leave those next 4 lines if you care about users using IE8 -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div class="container" style="margin-top: 10px" id="app">
    <div class="row">
        <div class="col-md-6">
            <form class="form-inline">
                <div class="form-group">
                    <label>Enter GitHub Username</label>
                    <input class="form-control" v-model="username" name="username" id="username"/>
                </div>
                <button type="submit" class="btn btn-default" @click="search($event)">Search</button>
                <button class="btn btn-warning" @click="clear($event)">Clear</button>
            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in results">
                    <img height="25" :src="result.avatar_url">
                    @{{result.login}}
                </li>
            </ul>
            <button v-show="showLoadMore" class="btn btn-success" @click="loadMore($event)">Load More</button>
        </div>
    </div>
</div>

<!-- Including Bootstrap JS (with its jQuery dependency) so that dynamic components work -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
<script>

    new Vue({
        el: "#app",
        data: {
            results: [],
            username: "",
            page: 1,
            showLoadMore: false
        },
        methods: {
            search: function (e) {
                var self = this;
                e.preventDefault();
                $.ajax({
                    url: '{{url("search")}}',
                    data: {username: self.username, page: self.page},
                    method: "get",
                    success: function (response) {
                        console.log(response);
                        var followers = JSON.parse(response);
                        if(followers.length === 0) self.showLoadMore = false;
                        else {
                            self.showLoadMore = true;
                            for(var i=0; i<followers.length; i++) {
                                self.results.push(followers[i]);
                            }
                        }

                    },
                    error: function (response) {
                        alert(response.responseText);
                    }
                })
            },
            loadMore: function(e) {
                this.page += 1;
                this.search(e);
            },
            clear: function(e) {
                e.preventDefault();
                this.showLoadMore = false;
                this.results = [];
                this.page = 1;
                this.username = "";
            }
        }
    })
    ;
</script>
</body>
</html>
