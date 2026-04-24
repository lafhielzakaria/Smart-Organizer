window.banUser = function(userId, btn) {
    $.ajax({
        url: `/admin/users/${userId}/ban`,
        type: 'POST',
        data: {
            _token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function() {
            const row = $(btn).closest('tr');
            row.find('.badge').removeClass('badge-active').addClass('badge-banned').text('Banned');
            $(btn).removeClass('btn-ban').addClass('btn-unban').text('Unban').attr('onclick', `unbanUser(${userId},this)`);
        },
        error: function() {
            alert('Error banning user');
        }
    });
};

window.unbanUser = function(userId, btn) {
    $.ajax({
        url: `/admin/users/${userId}/unban`,
        type: 'POST',
        data: {
            _token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function() {
            const row = $(btn).closest('tr');
            row.find('.badge').removeClass('badge-banned').addClass('badge-active').text('Active');
            $(btn).removeClass('btn-unban').addClass('btn-ban').text('Ban').attr('onclick', `banUser(${userId},this)`);
        },
        error: function() {
            alert('Error unbanning user');
        }
    });
};

window.banLocal = function(localId, btn) {
    $.ajax({
        url: `/admin/locals/${localId}/ban`,
        type: 'POST',
        data: {
            _token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function() {
            const row = $(btn).closest('tr');
            row.find('.badge').removeClass('badge-active').addClass('badge-banned').text('Banned');
            $(btn).removeClass('btn-ban').addClass('btn-unban').text('Unban').attr('onclick', `unbanLocal(${localId},this)`);
        },
        error: function() {
            alert('Error banning local');
        }
    });
};

window.unbanLocal = function(localId, btn) {
    $.ajax({
        url: `/admin/locals/${localId}/unban`,
        type: 'POST',
        data: {
            _token: document.querySelector('meta[name="csrf-token"]').content
        },
        success: function() {
            const row = $(btn).closest('tr');
            row.find('.badge').removeClass('badge-banned').addClass('badge-active').text('Active');
            $(btn).removeClass('btn-unban').addClass('btn-ban').text('Ban').attr('onclick', `banLocal(${localId},this)`);
        },
        error: function() {
            alert('Error unbanning local');
        }
    });
};
