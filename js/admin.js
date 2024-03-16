function search() {
    let searchInput = document.getElementById('searchItem');
    let itemOl = document.getElementById('itemList');
    var len = itemOl.children.length;
    let child = itemOl.children;
    var text = searchInput.value;
    text = text.toLowerCase();

    for (i = 0; i < len; i++) {
        if (!child[i].textContent.toLowerCase().includes(text)) {
            // child[i].classList.add('item_list');
            child[i].style.display = "none";

        }
        else {
            // child[i].classList.remove('item_list');
            child[i].style.display = "block";
        }
    }
}

function filterDays(days) {
    let currentDate = new Date();
    let currenTimestamp = currentDate.getTime();

    let year = currentDate.getFullYear();
    let month = currentDate.getMonth();
    month++;
    let date = currentDate.getDate();
    let strMonth = month.toString();
    let strDate = date.toString();
    if (strMonth.length == 1)
        month = '0' + month;
    if (strDate.length == 1)
        date = '0' + date;
    let dateTo = date + "/" + month + "/" + year;

    let lastTimestamp = currenTimestamp - (days * 24 * 60 * 60 * 1000);
    let lastDate = new Date(lastTimestamp);

    year = lastDate.getFullYear();
    month = lastDate.getMonth();
    month++;
    date = lastDate.getDate();
    strMonth = month.toString();
    strDate = date.toString();
    if (strMonth.length == 1)
        month = '0' + month;
    if (strDate.length == 1)
        date = '0' + date;
    let dateFrom = date + "/" + month + "/" + year;

    let arr = document.getElementsByClassName('uploadedDate');
    let arr_l = arr.length;
    for (i = 0; i < arr_l; i++) {
        var dateCheck = arr[i].textContent;

        var d1 = dateFrom.split("/");
        var d2 = dateTo.split("/");
        var c = dateCheck.split("-");

        var from = new Date(d1[2], parseInt(d1[1]) - 1, d1[0]);  // -1 because months are from 0 to 11
        var to = new Date(d2[2], parseInt(d2[1]) - 1, d2[0]);
        var check = new Date(c[0], parseInt(c[1]) - 1, c[2]);

        let itemOl = document.getElementById('itemList');
        let child = itemOl.children;

        if (check >= from && check <= to) {
            child[i].style.display = "block";
        }
        else {
            child[i].style.display = "none";
        }

    }
    let removeFilter = document.getElementById('removeFilter');
    removeFilter.style.display = "block";
}

function removeFilters() {
    let removeFilter = document.getElementById('removeFilter');
    removeFilter.style.display = "none";


    let itemOl = document.getElementById('itemList');
    var len = itemOl.children.length;
    let child = itemOl.children;

    for (i = 0; i < len; i++) {
        child[i].style.display = "block";
    }
}

function myFunction() {
    document.getElementById("myFilter").classList.toggle("show");
}

function filterFunction() {
    var input, filter, ul, li, a, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myFilter");
    a = div.getElementsByTagName("a");
    for (i = 0; i < a.length; i++) {
        txtValue = a[i].textContent || a[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            // a[i].style.display = "";
        } else {
            // a[i].style.display = "none";
        }
    }
}