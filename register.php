<?php 
include('albab_navbar.php');

// Check the user's role and redirect if not admin
?>
<body>
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Register</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Registration</p>
            </div>
        </div>
    </div>
    <div class="container">

        <div id="app">
            <form @submit="handleSubmit" method="post" action="register_validation.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="user_name"> User Name:</label>
                    <input v-model="userData.user_name" type="text"  name="user_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email"> Email:</label>
                    <input v-model="userData.email" type="text"  name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pass1">Password:</label>
                    <input v-model="userData.pass1" type="password" name="pass1" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="pass2">Confirm Password:</label>
                    <input v-model="userData.pass2" type="password" name="pass2"  class="form-control" required>
                </div>
                <div class="form-group">
                 <label for="role">Role:</label>
                <select v-model="userData.role" name="role" class="form-control" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
    </select>
</div>

                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script>
       new Vue({
       el: '#app',
       data: {
    userData: {
        user_name: '',
        email: '',
        pass1: '',
        pass2: '',
        role: 'user' // Set the default role to 'teacher'
    }
},

    methods: {
        handleSubmit(event) {
            if (this.userData.pass1 !== this.userData.pass2) {
                alert("Passwords do not match.");
                event.preventDefault();
            }
        }
    }
});
</script>

<?php include('albab_footer.php');?>
</body>
</html>
