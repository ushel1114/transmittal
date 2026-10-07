document.addEventListener('DOMContentLoaded', function() {
    const loginDialog = document.querySelector('.loginDialog');
    const adminLoginDialog = document.querySelector('.adminLoginDialog');
    const channelButtons = document.querySelectorAll('.channelLogin');
    const adminButton = document.querySelector('.adminLoginButton');
    const closeButtons = document.querySelectorAll('.closeModal');
    const closeAdminButtons = document.querySelectorAll('.closeAdminModal');

    const loginForm = document.getElementById('loginForm');
    const loginChannel = document.getElementById('loginChannel');
    const loginIcon = document.getElementById('loginIcon');
    const loginTitle = document.getElementById('loginTitle');
    const usernameLabel = document.getElementById('usernameLabel');
    const loginUsername = document.getElementById('loginUsername');

    const channelConfig = {
        'OD': {
            icon: 'OD',
            title: 'Officer of the Day Login',
            usernameLabel: 'Username',
            usernamePlaceholder: 'Enter your username'
        },
        'Email': {
            icon: 'EM',
            title: 'Email Handler Login',
            usernameLabel: 'Name',
            usernamePlaceholder: 'Enter your username'
        },
        'Facebook': {
            icon: 'FB',
            title: 'Facebook Handler Login',
            usernameLabel: 'Username',
            usernamePlaceholder: 'Enter your username'
        }
    };

    channelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const channel = this.getAttribute('data-channel');

            if (channel && ['OD', 'Email', 'Facebook'].includes(channel)) {
                console.log('Channel button clicked:', channel);

                const config = channelConfig[channel];

                if (config) {
                    loginChannel.value = channel;
                    loginIcon.textContent = config.icon;
                    loginTitle.textContent = config.title;
                    usernameLabel.textContent = config.usernameLabel;
                    loginUsername.placeholder = config.usernamePlaceholder;

                    loginDialog.showModal();
                }
            }
        });
    });

    if (adminButton) {
        adminButton.replaceWith(adminButton.cloneNode(true));

        const freshAdminButton = document.querySelector('.adminLoginButton');

        freshAdminButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.stopImmediatePropagation();

            console.log('ADMIN BUTTON CLICKED - EXCLUSIVE HANDLER');

            if (loginDialog && loginDialog.open) {
                loginDialog.close();
            }

            adminLoginDialog.showModal();
        });
    }

    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            loginDialog.close();
        });
    });

    loginDialog.addEventListener('click', function(e) {
        if (e.target === loginDialog) {
            loginDialog.close();
        }
    });

    closeAdminButtons.forEach(button => {
        button.addEventListener('click', function() {
            adminLoginDialog.close();
        });
    });

    adminLoginDialog.addEventListener('click', function(e) {
        if (e.target === adminLoginDialog) {
            adminLoginDialog.close();
        }
    });

    const adminLoginForm = document.getElementById('adminLoginForm');
    if (adminLoginForm) {
        adminLoginForm.addEventListener('submit', function(e) {
        });
    }
});
