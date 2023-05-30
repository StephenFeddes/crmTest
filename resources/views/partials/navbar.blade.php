        <nav>
            <a href="./dashboard"><i class="uil uil-apps"></i></a>
            <a href="./tickets" class="nav-btn">
                <div class="rectangle"></div>
                <p>Tickets</p>
            </a>
            <a href="./employees" class="nav-btn">
                <div class="rectangle"></div>
                <p>Employees</p>
            </a>
            <div id="signout">
                <p>{{ $user->username }}</p>
                <a href="./logout"><i class="uil uil-signout"></i></a>
            </div>
        </nav>
        <div class="rectangle nav-bottom"></div>