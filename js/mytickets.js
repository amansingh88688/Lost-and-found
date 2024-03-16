function search() {
    let searchInput = document.getElementById('searchItem');
    let itemOl1 = document.getElementById('itemList1');
    let itemOl2 = document.getElementById('itemList2');
    var len1 = itemOl1.children.length;
    var len2 = itemOl2.children.length;
    let child1 = itemOl1.children;
    let child2 = itemOl2.children;
    var text = searchInput.value;
    text = text.toLowerCase();

    for (i = 0; i < len1; i++) {
        if (!child1[i].textContent.toLowerCase().includes(text)) {
            child1[i].style.display = "none";
        }
        else {
            child1[i].style.display = "block";
        }
    }
    for (i = 0; i < len2; i++) {
        if (!child2[i].textContent.toLowerCase().includes(text)) {
            child2[i].style.display = "none";
        }
        else {
            child2[i].style.display = "block";
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

    let arr1 = document.getElementsByClassName('uploadedDate1');
    let arr_l1 = arr1.length;
    for (i = 0; i < arr_l1; i++) {
        var dateCheck = arr1[i].textContent;

        var d1 = dateFrom.split("/");
        var d2 = dateTo.split("/");
        var c = dateCheck.split("-");

        var from = new Date(d1[2], parseInt(d1[1]) - 1, d1[0]);  // -1 because months are from 0 to 11
        var to = new Date(d2[2], parseInt(d2[1]) - 1, d2[0]);
        var check = new Date(c[0], parseInt(c[1]) - 1, c[2]);

        let itemOl1 = document.getElementById('itemList1');
        let child1 = itemOl1.children;

        if (check >= from && check <= to) {
            child1[i].style.display = "block";
        }
        else {
            child1[i].style.display = "none";
        }
    }
    let arr2 = document.getElementsByClassName('uploadedDate2');
    let arr_l2 = arr2.length;
    for (i = 0; i < arr_l2; i++) {
        var dateCheck = arr2[i].textContent;

        var d1 = dateFrom.split("/");
        var d2 = dateTo.split("/");
        var c = dateCheck.split("-");

        var from = new Date(d1[2], parseInt(d1[1]) - 1, d1[0]);  // -1 because months are from 0 to 11
        var to = new Date(d2[2], parseInt(d2[1]) - 1, d2[0]);
        var check = new Date(c[0], parseInt(c[1]) - 1, c[2]);

        let itemOl2 = document.getElementById('itemList2');
        let child2 = itemOl2.children;

        if (check >= from && check <= to) {
            child2[i].style.display = "block";
        }
        else {
            child2[i].style.display = "none";
        }
    }
    let removeFilter = document.getElementById('removeFilter');
    removeFilter.style.display = "block";
}

function removeFilters() {
    let removeFilter = document.getElementById('removeFilter');
    removeFilter.style.display = "none";


    let itemOl1 = document.getElementById('itemList1');
    var len1 = itemOl1.children.length;
    let child1 = itemOl1.children;
    let itemOl2 = document.getElementById('itemList2');
    var len2 = itemOl2.children.length;
    let child2 = itemOl2.children;

    for (i = 0; i < len1; i++) {
        child1[i].style.display = "block";
    }
    for (i = 0; i < len2; i++) {
        child2[i].style.display = "block";
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