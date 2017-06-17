console.log("script incarcat");
//Afiseaza ora si data la incarcare
window.onload = time();

function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}

function time() {
    var today = new Date();
    var y = today.getFullYear();
    var mo = today.getMonth();
    var d = today.getDate();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    s = addZero(s);
    m = addZero(m);
    mo = mo + 1;
    document.getElementById("time").innerHTML = h + ':' + m + ":" + s;
    var t = setTimeout(time, 1000);

    document.getElementById("date").innerHTML = d + "." + mo + "." + y;
};

function toggleClass(item) {
    console.log("click");
    var tbody = item.parentElement.querySelector("tbody").classList;
    if (tbody.contains("hidden")) {
        tbody.remove("hidden");
        console.log("show");
    } else {
        tbody.add("hidden");
        console.log("collapse");
    }
    ;

};

function toggleTab(thead) {
    console.log("click");
    var tbody = thead.parentElement.querySelector("tbody");
    if (tbody.style.visibility == "collapse") {
        tbody.style.visibility = "visible";
        console.log("hidden");
    } else {
        tbody.style.visibility = "collapse";
        console.log("collapse");
    }
    ;

};

function addRows(item) {

    if ($(item).data('clicked') === 'da') {
        return;
    }

    $(item).data('clicked', 'da');

    var row_num = $("tbody tr").length;
    console.log(row_num);

    console.log("Functie addRows");
    var insertNode = $("tbody tr:last-child").clone();
    insertNode.appendTo("tbody");
    row_num++;
    insertNode.attr("id", row_num);

    var td = $("tbody tr:last-child td:first").html(row_num);
    console.log(row_num);

    var children = $(insertNode).find('select,textarea,input');

    $.each(children, function (index, child) {
        var name = $(child).attr('name').replace("[" + (row_num - 1) + "]", "[" + row_num + "]");
        console.log(name);
        $(child).attr('name', name);
    });
}

/* sterge panoul de informare (statusul la operatiune)
 */
function removeStatus() {
    div = $('#status_baloon');
        div.fadeOut(1000, function () {
            div.remove();
        });
}
// sterge angajat din work_days
function submitOnClick(item) {
    if ($(item).data("clicked") !== "da") {
        $(item).data("clicked", "da");
        var c = confirm("Sigur doriti sa stergeti persoana din tabel???");
        if (c == 0) {
            $(item).data("clicked", "nu");
            console.log("executarea ajax a fost anulata");
            item.preventDefault();
        } else {
            var id_workday = $(item).closest("form").find("input[name='remove_id']").val();
            console.log("urmeaza executarea ajax id: " + id_workday);

            $.post('../includes/delete.php',
                {remove_id: id_workday},
                function (data, status) {
                    // alert(status+" data: "+data);
                    $(item).closest(".thead").addClass("disabled");
                    console.log("executat ajax");
                }
            );
        }
    }
}
// adauga disabled la un camp
function addDisabled(item) {
    console.log("intrat in functie addDisabled");
    var input = $(item).closest("td").next().find("input");
    var key = $(item).attr("name");
    if ($(item).is(':checked')) {
        $(item).data(key, input.val());
        input.val('0');
        input.prop('disabled', true);
    } else {
        input.val($(item).data(key));
        input.prop('disabled', false);
    }
}
// activeaza campul la click
function clickForEnable(item) {

    console.log("intrat in functie clickForDisable");
    var input = $(item).closest("span").next();
    var val = input.next().val();
    console.log(input.attr("name"));
    console.log(val);
    if ($(item).is(':checked')) {
        input.val(null);
        input.prop('disabled', true);
    } else {
        input.val(val);
        input.prop('disabled', false);
    }
}
// verifica datele pentru logare
function checkPass() {
    var pass = $("#pass").val();
    var pass_con = $("#pass_con").val();
    console.log(pass+" si "+pass_con);
    if (pass !== pass_con) {
        $("#submit_butt").prop("disabled", true);
        $("#pass_err").html("NU COINCID PAROLELE!");
        $("#pass_field").addClass("has-error").removeClass("has-success");
        $("#pass_con_field").addClass("has-error").removeClass("has-success");
        $(".pass-icon").addClass(" glyphicon-warning-sign ").css("color", "red").removeClass(" glyphicon-ok")
    }else {
        $("#submit_butt").prop("disabled", false);
        $("#pass_field").addClass("has-success").removeClass("has-error");
        $("#pass_con_field").addClass("has-success").removeClass("has-error");
        $(".pass-icon").addClass(" glyphicon-ok ").css("color", "green").removeClass(" glyphicon-warning-sign ")
        $("#pass_err").html("<i>Super, acum coincid!</i>");
    }
}

                                         /* Tot ce e pntru AJAX */
// verifica de unde vine comanda si te trimte pe ang_rulaj_1
function getEmployeeActivityByDat(item) {
    $('.adaugat').remove();
    var urlParam = $(item).attr('id');
    var url = '../includes/month_work_info.php?id='+urlParam;
    console.log(url);
    $.get(url,
        function (data, status) {
            var tr= $(item).closest('tr');
            $("<tr class='adaugat'><td colspan='4' >UN TD nou!!</td> </tr>").insertAfter(tr);
            $(".adaugat").replaceWith(data);
            console.log(data);
            console.log(status);
        });
}
// verifica de unde vine comanda si te trimte pe ang_rulaj_1
function incarcaAngajatiiDupaData(item, link) {
    if ($(item).attr("name") == "date") {
        ceva = item.options[item.selectedIndex].value;
        type = "insert";
        $('#calendar_date').val('');
        console.log("setat calendar pe 0");
    } else {
        ceva = $(item).val();
        type = "update";
        $('#select_date').val('0');
        console.log("setat calendar pe 0");
    }
    console.log("data selectata: " + ceva);
    $.post(link,
        {
            date: ceva,
            fun: type
        },
        function (data, status) {
            //  console.log(data);
            $("#for_replace").html(data);
            console.log(status)
        })
}
// Incarca anactivitatile pentru luna aleasa
function displayActivityTabs(nr) {
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results===null){
            return null;
        }
        else{
            return decodeURI(results[1]) || 0;
        }
    };
    var url = '../includes/activity_data.php?id='+$.urlParam('id')+"&tab="+nr;
    $.get(url,
        function (data, status) {
            //  console.log(data);
            $("#for_replace").html(data);
            console.log(status)
        });
}
