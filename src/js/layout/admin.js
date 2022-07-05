function sfeed_admin_static_event_listeners() {
    if (document.querySelector('.sfeed-user-add')) {
        document.querySelectorAll('.sfeed-user-add').forEach(elem => {
            elem.addEventListener('click', e => {
                let sfeed_grid = document.querySelector('.sfeed-users');
                let sfeed_html = '<div class="sfeed-user"><div class="sfeed-user-header"><button class="sfeed-user-remove">✕</button></div><form class="sfeed-user-form"><div><label>S-Feed URL:</label><input type="text" name="sfeed-url" class="sfeed-url" value=""> </div> </form><div class="sfeed-user-options"><a class="_button sfeed-user-key" target="_blank" href="https://social-feed.tech/">Retrieve S-Feed URL</a><p>Click "Save All" below to register this new S-Feed URL to the database.</p><p class="sfeed-user-status">Status: New User</p></div></div>';
                sfeed_grid.innerHTML += sfeed_html;

                sfeed_admin_dynamic_event_listeners();
            });
        });
    }

    if (document.querySelector('.sfeed-users-save')) {
        document.querySelectorAll('.sfeed-users-save').forEach(elem => {
            elem.addEventListener('click', e => {
                elem.disabled = true;
                elem.innerText = 'Saving..';
                sfeed_admin_save();
            });
        });
    }
}
window.addEventListener('DOMContentLoaded', sfeed_admin_static_event_listeners);

function sfeed_admin_dynamic_event_listeners() {
    // Buttons to remove locations
    if (document.querySelector('.sfeed-user-remove')) {
        document.querySelectorAll('.sfeed-user-remove').forEach(elem => {
            elem.addEventListener('click', e => {
                e.target.closest('.sfeed-user').remove();
            });
        });
    }
}
window.addEventListener('DOMContentLoaded', sfeed_admin_dynamic_event_listeners);

function sfeed_admin_collect_data() {
    let users = [];
    if (document.querySelector('.sfeed-user form')) {
        document.querySelectorAll('.sfeed-user form').forEach(elem => {
            let user = {
                url: encodeURIComponent(elem.querySelector('input.sfeed-url').value)
            }

            users.push(user);
        });
    }

    return users;
}

function sfeed_admin_save() {
    let req = sfeed_admin_collect_data();
    console.log('Request:', req);
    // console.log(JSON.stringify(req));

    fetch(sfeed.ajaxurl, {
        method: 'POST',
        headers: new Headers({
            'Content-Type': 'application/x-www-form-urlencoded'
        }),
        credentials: 'same-origin',
        body: 'action=sfeed_users_save&data=' + JSON.stringify(req),
    })
    .then(response => response.text())
    .then(data => {
        console.log('Response:', data);

        document.querySelectorAll('.sfeed-users-save').forEach(elem => {
            elem.innerText = 'Saved!';
        });

        setTimeout(() => {
            document.querySelectorAll('.sfeed-users-save').forEach(elem => {
                elem.disabled = false;
                elem.innerText = 'Save All';
                window.location.reload();
            });
        }, 1000);

    })
    .catch(function (error) {
        console.log(error);
        return error;
    });
}

