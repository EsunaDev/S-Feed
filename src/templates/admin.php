<div class="sfeed-admin _container">
    <header class="sfeed-header">
        <h1>S-Feed</h1>
        <h3>Access simple Instagram data to use in your WordPress editor.</h3>
    </header>
    <main class="sfeed-main">
        <div class="sfeed-users">
        <?php
        $users = sfeed_users_load();
        if ($users):
            foreach ($users as $user):
                $feed = sfeed_get_instagram($user['url']);
                $data = sfeed_parse_url($user['url']);


                $status = 'Inactive';
                $info = 'You must be logged into the Instagram account in order to retrieve your S-Feed URL.';

                if ($feed) {
                    $status = 'Active';
                    $info = 'To display your feed, use the following shortcode: <code>[sfeed user=' . $data['username'] . ' grid=3 limit=6]</code><br><br>Adjusting the grid attribute will set the amount of grid columns. Adjusting the limit attribute will set the amount of photos to display.';
                }
            ?>
                <div class="sfeed-user -<?= strtolower($status) ?>">
                    <div class="sfeed-user-header">
                        <button class="sfeed-user-remove">✕</button>
                    </div>
                    <form class="sfeed-user-form">
                        <div>
                            <label>S-Feed URL:</label>
                            <input type="text" name="sfeed-url" class="sfeed-url" value="<?= $user['url'] ?>">
                        </div>
                    </form>
                    <div class="sfeed-grid sfeed-grid-3">
                        <?php 
                        if ($feed) {
                            foreach ($feed as $key => $single) {
                                echo '<img src="' . $single['image_url'] .'" />';
                            } 
                        }
                        ?>
                    </div>
                    <div class="sfeed-user-options">
                        <?php if ($status == 'Inactive'): ?>
                        <a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a>
                        <?php endif; ?>
                        <p><?= $info ?></p>
                        <p class="sfeed-user-status -<?= strtolower($status) ?>">Status: <?= $status ?></p>
                    </div>
                </div>
        <?php
            endforeach;
        else:
            ?>
            <div class="sfeed-user">
                <div class="sfeed-user-header">
                    <button class="sfeed-user-remove">✕</button>
                </div>
                <form class="sfeed-user-form">
                    <div><label>S-Feed URL:</label><input type="text" name="sfeed-url" class="sfeed-url" value=""></div>
                </form>
                <div class="sfeed-user-options">
                    <a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a>
                    <p>Click "Save All" below to register this new S-Feed URL to the database.</p>
                    <p class="sfeed-user-status">Status: New User</p>
                </div>
            </div>
        <?php
        endif;
        ?>
        </div>
    </main>
    <footer class="sfeed-footer">
        <button class="sfeed-user-add">Add User</button>
        <button class="sfeed-users-save">Save All</button>
    </footer>
</div>