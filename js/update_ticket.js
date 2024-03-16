
function deleteTicket(msg, id) {
    if (confirm(msg)) {
        window.location.href = "delete_ticket_admin.php?id=" + id;
    }
}

function approveTicket(msg, id) {
    if (confirm(msg)) {
        window.location.href = "approve_ticket.php?id=" + id;
    }
}

