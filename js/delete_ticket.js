
function deleteTicket(msg, id) {
    if (confirm(msg)) {
        window.location.href = "delete_ticket.php?id=" + id;
    }
}