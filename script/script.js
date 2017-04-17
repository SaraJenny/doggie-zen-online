/* Sara Petersson - Web 2.0, DT091G */

// Kollar att dokumentet är redo
$(document).ready(function() {
    /*
    ALLMÄNT
    */
    // Hover-event för knappar
    $('.button').hover(
        // Mouseenter: ändrar till grön färg
        function() {
            $(this).css('background-color', '#38b07e');
        },
        // Mouseout: ändrar tillbaka till orange
        function() {
            $(this).css('background-color', '#ee7300');
        }
    );
    /* Om användaren trycker på Enter anropas olika funktioner beroende på vilken sida användaren är på */
    $(document).keypress(function(e) {
        if(e.which == 13) {
            var pathname = window.location.pathname;
            if (pathname == "/login.php") {
                loginUser();
            }
            else if (pathname == "/register.php") {
                registerUser();
            }
            else if (pathname == "/publish.php") {
                publishPost();
            }
        }
    });
    /*
    LOGIN.PHP
    */
    $('#loginButton').click(
        function() {
            loginUser();
        }
    );
    // Inskrivna uppgifter valideras, ev. felmeddelanden skrivs ut, AJAX-anrop för inloggning
    function loginUser() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Skapa variabler
        var email = $('#email').val();
        var password = $('#password').val();
        var hasError = false;
        // Kollar om e-post och lösenord fyllts i
        if (email == '' && password == '') {
            $('<p class="errorMessageBox">Du måste fylla i din e-post och ditt lösenord</p>').insertBefore('#login');
            hasError = true;
        }
        // Kollar om e-post fyllts i
        else if (email == '') {
            $('<p class="errorMessageBox">Du måste fylla i din e-post</p>').insertBefore('#login');
            hasError = true;
        }
        // Kollar om lösenord fyllts i
        else if (password == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett lösenord</p>').insertBefore('#login');
            hasError = true;
        }
        // Om inga fel hittas görs ett AJAX-anrop för att kontrollera att inloggningsuppgifterna stämmer
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/loginUser.php',
                data: {
                    email: email,
                    password: password
                }
            }).done(function(result) {
                // Om inloggningen var korrekt skickas användaren till index-php
                if (result == true) {
                    window.location.href = 'index.php';
                }
                // Om inloggningen misslyckades skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">' + result + '</p>').insertBefore('#login');
                }
            });
        }
    }
    /*
    REGISTER.PHP
    */
    /* Efter användaren tryckt på "Registrera"-knapp anropas funktionen registerUser() */
    $('#registerButton').click(function() {
        registerUser();
    });
    /* Validerar inskrivna uppgifter, ev. felmeddelanden skrivs ut,
    AJAX-anrop för att lägga till användaren i databasen */
    function registerUser() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Skapa variabler
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var passwordCheck = $('#passwordCheck').val();
        // Validerar förnamn, efternamn och e-post genom funktionen validateUserInfo()
        var hasError = validateUserInfo(firstname, lastname, email);
        var hasPasswordError = validatePassword(password, passwordCheck);
        // Om inga fel hittas görs ett AJAX-anrop för att lägga till användaren till databasen
        if (hasError == false && hasPasswordError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/registerUser.php',
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    password: password
                }
                
            }).done(function(result) {
                // Om användaren lades till i databasen skickas denna till index.php
                if (result == true) {
                    window.location.href = 'index.php';
                }
                // Om användaren inte kunde läggas till i databasen skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">' + result + '</p>').insertAfter('#registerButton');
                }
            });
        }
    }
    /*
    PROFILE.PHP
    */
    // Då en fil dras över dropzone förändras färgen
    $('.dropzone').on('dragover', function(e){
        e.stopPropagation();
        e.preventDefault();
        $(e.target).addClass('dragover');
        // Tar bort eventuella felmeddelanden
        $('#uploads').html('');
        $('#uploads').removeClass('errorMessageBox');
    });
    // Då en fil dras ifrån dropzone återställs färgen
    $('.dropzone').on('dragleave', function(e){
        e.stopPropagation();
        e.preventDefault();
        $(e.target).removeClass('dragover');
    });
    /* Då en fil släpps över dropzone återställs färgen, en koll görs att filen är av rätt filformat och är mindre än 100kB.
    Skickar till funktionen upload() om inga felmeddelanden getts*/
    $('.dropzone').on('drop', function(e){
        e.stopPropagation();
        e.preventDefault();
        $(e.target).removeClass('dragover');
        var files = e.originalEvent.dataTransfer.files;
        file = files[0];
        // Kolla att filen är en JPEG
        if (file.type != "image/jpeg") {
            $('#uploads').html('<p>Endast jpeg är tillåtet</p>');
            $('#uploads').addClass('errorMessageBox');
        }
        // Kolla att filstorleken är mindre än 100kB
        else if (file.size > 100000) {
            $('#uploads').html('<p>Filen är för stor (max 100kB)</p>');
            $('#uploads').addClass('errorMessageBox');
        }
        // Ladda upp bilden
        else {
            upload(files);
        }
    });
    // Visar den uppladdade bilden i uppladdningsrutan genom att skapa ett nytt bildelement
    function displayUploads(data) {
        var anchor;
        anchor = document.createElement('img');
        anchor.src = data[0].file;
        anchor.alt = data[0].name;
        $('#dropzone').html(anchor);
    }
    // Laddar upp bildfilen med AJAX
    function upload(files) {
        var formData = new FormData(),
        xhr = new XMLHttpRequest(),
        x;
        // Begränsar till att endast kunna ladda upp en bild
        for (x = 0; x < 1; x++) {
            formData.append('file[]', files[x]);
        }
        // Tar emot svar och skickar vidare till funktionen displayUploads() som visar den uppladdade bilden
        xhr.onload = function() {
            var data = JSON.parse(this.responseText);
            displayUploads(data);
            // Ändrar pilbildens källa
            $("#arrow").attr("src","images/arrow_change.png");
        }
        xhr.open('post', 'ajax/upload.php');
        xhr.send(formData);
    }
    /* Vid klick av "Uppdatera" för användare valideras uppgifterna,
    ev. felmeddelanden skrivs ut, AJAX-anrop görs för att uppdatera uppgifterna i databasen */
    $('#userButton').click(function() {
        // Radera ev. meddelanden
        $(".errorMessageBox").remove();
        $('.successMessage').remove();
        // Skapa variabler
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        // Validerar förnamn, efternamn och e-post genom funktionen validateUserInfo()
        var hasError = validateUserInfo(firstname, lastname, email);
        // Om inga fel hittas görs ett AJAX-anrop för att uppdatera användaren i databasen
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/updateUser.php',
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email
                }
            }).done(function(result) {
                // Om uppgifterna uppdaterades i databasen skrivs ett meddelande ut via funktionen showMessage()
                if (result == true) {
                    var msg = 'Dina uppgifter har uppdaterats';
                    showMessage(msg);
                }
                // Om uppgifterna inte kunde uppdateras i databasen skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">Dina uppgifter kunde tyvärr inte uppdateras</p>').insertAfter('#userButton');
                }
            });
        }
    });
    // Vid klick av " + Lägg till" fälls ett nytt formulär ut för att kunna lägga till en hund
    $('#addDog').click(function() {
        $('#newDog').toggle('slow');
    });
    /* Validerar formuläret för att byta lösenord vid tryck på "Ändra lösenord",
    ev. felmeddelanden skrivs ut, AJAX-anrop görs för att ändra lösenordet i databasen */
    $('#passwordButton').click(function() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Spara variabler
        var password = $('#password').val();
        var passwordCheck = $('#passwordCheck').val();
        var hasError = validatePassword(password, passwordCheck);
        // Om inga fel hittas görs ett AJAX-anrop för att byta lösenord
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/changePassword.php',
                data: {
                    password: password
                }
            }).done(function(result) {
                // Om lösenordet har uppdaterats töms lösenordsfälten och ett meddelande skrivs ut via funktionen showMessage()
                if (result == true) {
                    $('#password').val('');
                    $('#passwordCheck').val('');
                    var msg = 'Ditt lösenord har ändrats';
                    showMessage(msg);
                }
                // Om lösenordet inte kunde uppdateras skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">Ditt lösenord kunde inte ändras</p>').insertAfter('#passwordButton');
                }
            });
        }
    });
    /*
    PUBLISH.PHP
    */
    /* Om knappen "Publicera" är tryckt anropas funktionen publishPost() */
    $('#submitPost').click(function() {
        publishPost();
    });
    /* Validerar formuläret för att publicera ett nytt inlägg,
    ev. felmeddelanden skrivs ut, AJAX-anrop görs för att spara inlägget i databasen */
    function publishPost() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Skapa variabler
        var classCode = $('#class').val();
        var title = $('#title').val();
        var editor = CKEDITOR.instances.editor.getData();
        var pubDate;
        var hasError = false;
        // Kollar om publiceringsdatum-elementet finns
        if ($('#pubDate').length) {
            // Om elementet finns sparas dess innehåll i en variabel
            pubDate = $('#pubDate').val();
            // Kollar om innehållet är tomt
            if (pubDate == '') {
                $('<p class="errorMessageBox">Du måste fylla i ett datum</p>').insertAfter('#pubDate');
                hasError = true;
            }
            // Kollar om innehållet kan valideras som ett datum genom funktionen validateDate()
            else if (validateDate(pubDate) != true) {
                $('<p class="errorMessageBox">Ogiltigt datumformat</p>').insertAfter('#pubDate');
                hasError = true; 
            }
        }
        // Om publiceringsdatum-elementet inte finns ges datum-variabeln aktuellt datum & tid
        else {
            pubDate = getDatetime();
        }
        // Kollar att en kurs har valts
        if (classCode == 0) {
            $('<p class="errorMessageBox">Du måste välja kurs. Har du inga kurser i listan innebär det att du inte har rättigheter att publicera inlägg i någon kurs.</p>').insertAfter('#class');
            hasError = true;
        }
        // Kollar att något har skrivits i editorn
        if (editor == '') {
            $('<p class="errorMessageBox">Du måste skriva ett inlägg</p>').insertAfter('#title');
            hasError = true;
        }
        // Kollar att Rubrik har skrivits
        if (title == '') {
            $('<p class="errorMessageBox">Du måste skriva en rubrik</p>').insertAfter('#title');
            hasError = true;
        }
        // Om inga fel hittas görs ett AJAX-anrop för att spara inlägget i databasen
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/addPost.php',
                data: {
                    classCode: classCode,
                    title: title,
                    content: editor,
                    pubDate: pubDate
                }
            }).done(function(result) {
                // Om inlägget sparades i databasen skickas användaren till det nyskapade inlägget
                if (result != false) {
                    window.location.href = 'post.php?post=' + result;
                }
                // Om inlägget inte sparades skrivs ett felmeddelande ut
                else {
                    // Skriv ut felmeddelande
                    $('<p class="errorMessageBox">' + result + '</p>').insertAfter('#submitPost');
                }
            });
        }
    }
    /*
    ADMIN.PHP
    */
    // Visar fältet för att kunna skapa ny kurs
    $('#addNewClass').click(function() {
        $('#addClassNameForm').hide();
        $('#addClass').toggle('slow');
    });
    /* Validerar formuläret för att lägga till ny kurs vid tryck på "Skapa kurs",
    ev. felmeddelanden skrivs ut, AJAX-anrop görs för att spara kursen i databasen */
    $('#addClassButton').click(function() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Skapa variabler
        var classId = $('#className').val();
        var classCode = $('#classCode').val();
        var startDate = $('#startDate').val();
        var endDate = $('#endDate').val();
        var closingDate = $('#closingDate').val();
        var teacher = $('#addClassForm input:radio[type="radio"]:checked').val();
        var hasError = false;
        // Kollar om kurs har valts
        if (classId == 0) {
            $('<p class="errorMessageBox">Du måste välja kursnamn</p>').insertAfter('#className');
            hasError = true;
        }
        // Kollar om kurskod angetts
        if (classCode == '') {
            $('<p class="errorMessageBox">Du måste fylla i en kurskod</p>').insertAfter('#classCode');
            hasError = true;
        }
        // Kollar att kurskoden består av 6 tecken
        else if (classCode.length > 6 || classCode.length < 6) {
            $('<p class="errorMessageBox">Kurskoden ska bestå av 6 tecken</p>').insertAfter('#classCode');
            hasError = true;
        }
        // Kollar att startdatum angetts
        if (startDate == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett datum</p>').insertAfter('#startDate');
            hasError = true;
        }
        // Kollar att startdatum validerar som datum genom funktionen validateDate()
        else if (validateDate(startDate) != true) {
            $('<p class="errorMessageBox">Ogiltigt datumformat</p>').insertAfter('#startDate');
            hasError = true; 
        }
        // Kollar att slutdatum angetts
        if (endDate == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett datum</p>').insertAfter('#endDate');
            hasError = true;
        }
        // Kollar att slutdatum validerar som datum genom funktionen validateDate()
        else if (validateDate(endDate) != true) {
                $('<p class="errorMessageBox">Ogiltigt datumformat</p>').insertAfter('#endDate');
                hasError = true;
        }
        // Kollar att stängningsdatum angetts
        if (closingDate == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett datum</p>').insertAfter('#closingDate');
            hasError = true;
        }
        // Kollar att stängningsdatum validerar som datum genom funktionen validateDate()
        else if (validateDate(closingDate) != true) {
                $('<p class="errorMessageBox">Ogiltigt datumformat</p>').insertAfter('#closingDate');
                hasError = true;
        }
        // Kollar att instruktör har valts
        if (!$('#addClassForm input:radio[type="radio"]').is(":checked")) {
            $('<p class="errorMessageBox">Du måste välja en instruktör</p>').insertBefore('#addClassButton');
            hasError = true;
        }
        // Om inga fel hittas görs ett AJAX-anrop för att lägga till kursen i databasen
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/addClass.php',
                data: {
                    classId: classId,
                    classCode: classCode,
                    startDate: startDate,
                    endDate: endDate,
                    closingDate: closingDate,
                    teacherId: teacher
                }
            }).done(function(result) {
                /* Om kursen lades till i databasen nollställs formuläret,
                formuläret försvinner och ett meddelande skrivs ut genom funktionen showMessage() */
                if (result == true) {
                    $('#className').val('0');
                    $('#classCode').val('');
                    $('#startDate').val('');
                    $('#endDate').val('');
                    $('#closingDate').val('');
                    $('#addClassForm input:radio[type="radio"]:checked').prop('checked', false);
                    $('#addClass').hide();
                    var msg = 'Kursen är tillagd i kursplanen';
                    showMessage(msg);
                }
                // Om kursen inte kunde läggas till i databasen skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">Tyvärr, kursen kunde inte läggas in i databasen</p>').insertAfter('#addClassButton');
                }
            });
        }
    });
    // Visa formulär för att skapa nytt kursnamn vid klick på "Lägg till kursnamn"
    $('#addClassName').click(function() {
        $('#addClassNameForm').toggle('slow');
    });
    /* Validerar formulär för att skapa nytt kursnamn vid klick på "Lägg till",
    skriver ut ev. felmeddelanden och gör ett AJAX-anrop för att lägga till namnet i databasen */
    $('#addNewClassName').click(function() {
        // Radera ev. felmeddelanden
        $(".errorMessageBox").remove();
        // Skapa variabler
        var newClassName = $('#newClassName').val();
        var hasError = false;
        // Kollar om fältet är tomt
        if (newClassName == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett kursnamn</p>').insertAfter('#newClassName');
            hasError = true;
        }
        // Om inga fel hittas görs ett AJAX-anrop för att lägga till namnet i databasen
        if (hasError == false) {
            $.ajax({
                method: 'POST',
                url: 'ajax/addClassName.php',
                data: {
                    newClassName: newClassName
                }
            }).done(function(result) {
                /* Om kursnamnet lades till i databasen töms och göms formuläret, det nya kursnamnet läggs till i kurslistan
                och ett meddelande skrivs ut genom funktionen showMessage() */
                if (result != false) {
                    $('#newClassName').val('');
                    $('#addClassNameForm').hide();
                    $('#className').append('<option value="' + result + '">' + newClassName + '</option>');
                    var msg = 'Kursnamnet är tillagt';
                    showMessage(msg);
                }
                // Om kursnamnet inte kunde läggas till skrivs ett felmeddelande ut
                else {
                    $('<p class="errorMessageBox">Tyvärr, kursnamnet kunde inte läggas in i databasen</p>').insertAfter('#addClassButton');
                }
            });
        }
    });
    /*
    FUNKTIONER
    */
    // Kontrollerar användarinformation
    function validateUserInfo(firstname, lastname, email) {
        var hasError = false;
        // Kollar att fältet inte är tomt
        if (firstname == '') {
            $('<p class="errorMessageBox">Du måste fylla i ditt förnamn</p>').insertAfter('#firstname');
            hasError = true;
        }
        // Kollar att fältet inte är tomt
        if (lastname == '') {
            $('<p class="errorMessageBox">Du måste fylla i ditt efternamn</p>').insertAfter('#lastname');
            hasError = true;
        }
        // Kollar att fältet inte är tomt
        if (email == '') {
            $('<p class="errorMessageBox">Du måste fylla i din e-post</p>').insertAfter('#email');
            hasError = true;
        }
        else {
            // Validerar e-posten genom funktionen validateEmail()
            var valid = validateEmail(email);
            if (valid != true) {
                $('<p class="errorMessageBox">Ogiltigt e-postformat</p>').insertAfter('#email');
                hasError = true;
            }
        }
        // Returnerar resultatet av hasError
        return hasError;
    }
    // Validerar e-post och returnerar 'true' eller 'false'
    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test(email);
    }
    // Validerar lösenord
    function validatePassword(password, passwordCheck) {
        var hasError = false;
        // Kollar att lösenordsfältet inte är tomt
        if (password == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett lösenord</p>').insertAfter('#password');
            hasError = true;
        }
        // Kollar om lösenordet är minst 6 tecken långt
        else if (password.length < 6) {
            $('<p class="errorMessageBox">Ditt lösenord måste bestå av minst 6 tecken</p>').insertAfter('#password');
            hasError = true;
        }
        // Kollar om lösenordet fyllts i det andra fältet
        if (passwordCheck == '') {
            $('<p class="errorMessageBox">Du måste fylla i ett lösenord</p>').insertAfter('#passwordCheck');
            hasError = true;
        }
        // Kollar om de båda lösenorden överensstämmer med varandra
        else if (passwordCheck != password) {
            $('<p class="errorMessageBox">Lösenordsfälten överensstämmer inte</p>').insertAfter('#passwordCheck');
            hasError = true;
        }
        return hasError;
    }
});
/*
FUNKTIONER (utanför $(document).ready())
*/
// Visar kommentarsfältet för ett specifikt inlägg
function showComments(postId) {
    $('#comment_' + postId).toggle('slow');
}
// Validerar och sparar kommentarer i databasen vid klick på "Skicka"
function submitComment(postId, firstname, lastname) {
    // Radera ev. meddelanden
    $(".errorMessageBox").remove();
    $('.successMessage').remove();
    // Skapa variabler
    var comment = $('#commentText_' + postId).val();
    // Hämtar aktuellt datum och tid genom funktionen getDatetime()
    var datetime = getDatetime();
    var hasError = false;
    // Kollar om kommentarsfältet är tomt
    if (comment == '') {
        $('<p class="errorMessageBox">Du måste skriva en kommentar</p>').insertAfter('#comment_' + postId);
        hasError = true;
    }
    // Om inga fel hittas görs ett AJAX-anrop för att spara kommentaren i databasen
    if (hasError == false) {
        $.ajax({
            method: 'POST',
            url: 'ajax/addComment.php',
            data: {
                postId: postId,
                content: comment,
                commentDate: datetime
            }
        }).done(function(result) {
            /* Om kommentaren sparats i databasen töms formuläret, siffran för antalet kommentarer för posten
            ökas med 1 och kommentaren postas överst bland kommentarerna */
            if (result == true) {
                $('#commentText_' + postId).val('');
                var commentNr = $('#circle_' + postId + ' p').html();
                var nr = parseInt(commentNr);
                nr = nr+1;
                $('#circle_' + postId).html('<p>' + nr + '</p>');
                $('#comment_' + postId ).prepend('<div class="oldComments"><p class="comInfo">' + firstname + ' ' + lastname + '</p><p class="comInfo smallPrint">' + datetime + '</p><p class="commentP">' + comment + '</p></div>');
            }
            // Om kommentaren inte kunde sparas i databasen skrivs ett felmeddelande ut
            else {
                $('<p class="errorMessageBox">kommentaren kunde tyvärr inte postas</p>').insertAfter('#comment_' + postId);
            }
        });
    }
}
// Visar mer information om specifik kursdeltagare då +-tecknet framför namnet klickas på
function showInfo(userId) {
    $('#oldStudentField_' + userId).toggle('slow');
}
// Ger kursdeltagare rättigheter till kurs
function submitStudent(userId, firstname, lastname) {
    // Radera ev. meddelanden
    $(".errorMessageBox").remove();
    $('.successMessage').remove();
    // Skapa variabler
    var classChoice = $('#class_' + userId).val();
    var type = $('#newStudentForm' + userId + ' input[name=type]:checked').val();
    var hasError = false;
    // Kollar att kurs har valts
    if (classChoice == 0) {
        $('<p class="errorMessageBox">Du måste välja en kurs</p>').insertAfter('#newStudentForm' + userId);
        hasError = true;
    }
    // Kollar att deltagartyp har valts
    if (type != 3 && type != 4) {
        $('<p class="errorMessageBox">Du måste välja deltagartyp</p>').insertAfter('#newStudentForm' + userId);
        hasError = true;
    }
    // Om inga fel hittas sparas vald kurs i en variabel och sedan görs ett AJAX-anrop för att spara kursdeltagandet i databasen
    if (hasError == false) {
        var classInfo = $('option[value="' + classChoice + '"]').html();
        $.ajax({
            method: 'POST',
            url: 'ajax/addStudentToClass.php',
            data: {
                userId: userId,
                classChoice: classChoice,
                type: type
            }
        }).done(function(result) {
            /* Om kursdeltagandet kunde läggas till i databasen görs förändringar beroende på
            om det var en ny eller gammal elev och ett meddelande skrivs ut genom funktionen showMessage() */
            if (result == true) {
                // Om det var en nyregistrerad användare tas eleven bort från den delen av sidan och läggs till under "Kursdeltagare"
                if ($('#newStudentDiv' + userId).length) {
                    $('#newStudentDiv' + userId).remove();
                    $('#oldStudents').append('<p><img src="images/add_13x13.png" alt="Mer info om ' + firstname + ' ' + lastname + '" class="info">' + firstname + ' ' + lastname + '</p>');
                }
                // Om det var en "gammal" elev läggs den nya kursen till bland dess kurser
                else {
                    $('#currentClassList_' + userId).prepend('<li>' + classInfo + '</li>');
                }
                var msg = firstname + ' ' + lastname + ' har fått tillgång till kursen ' + classInfo;
                showMessage(msg);
            }
            // Om kursdeltagandet inte kunde läggas till skrivs ett felmeddelande ut
            else {
                // Skriv ut felmeddelande
                $('<p class="errorMessageBox">Kursdeltagaren kunde inte läggas till</p>').insertAfter('#newStudentForm' + userId);
            }
        });
    }
}
// Lägger till hund då knappen "Lägg till hund" klickats på, efter att formulärdata validerats
function addDog() {
    // Radera ev. meddelanden
    $('.errorMessageBox').remove();
    $('.successMessage').remove();
    // Skapa variabler
    var dogId = '';
    var dogname = $('#dogname').val();
    var dob = $('#dob').val();
    var dogInfo = $('#dogInfo').val();
    // Validerar hundinformation genom funktionen validateDogInfo
    var hasError = validateDogInfo(dogId, dogname, dob, dogInfo);
    // Om inga fel hittas görs ett AJAX-anrop för att lägga till hunden i databasen
    if (hasError == false) {
        $.ajax({
            method: 'POST',
            url: 'ajax/addDog.php',
            data: {
                dogname: dogname,
                dob: dob,
                dogInfo: dogInfo
            }
        }).done(function(result) {
            /* Om hunden lades till i databasen töms och göms formuläret, "+ Lägg till hund"-länken syns igen,
            den nya hunden läggs till först bland hundarna och ett meddelande skrivs ut genom funktionen showMessage() */
            if (result != false) {
                $('#dogname').val('');
                $('#dob').val('');
                $('#dogInfo').val('');
                $('#newDog').hide();
                $('#addDog').show();
                $('#dogs').prepend('<div id="dogContainer_' + result + '"><h3 id="dognameTitle' + result + '">' + dogname + '<img src="images/delete.png" alt="Radera hund" class="delete deleteDog" onclick="deleteDog(' + result + ', &quot;' + dogname + '&quot;)"></h3><form class="registerForm"><label for="dogname' + result + '">Hundnamn</label><input placeholder="Hundnamn" type="text" name="dogname' + result + '" id="dogname' + result + '" value="' + dogname + '"><label for="dob' + result + '">Hundens födelsedatum (åååå-mm-dd)</label><input type="date" name="dob' + result + '" id="dob' + result + '" value="' + dob + '"><label for="dogInfo' + result + '">Hundinfo</label><textarea placeholder="Presentera din hund lite kort (ras, vad ni tränar etc.)" name="dogInfo' + result + '" id="dogInfo' + result + '">' + dogInfo + '</textarea><input id="dogButton' + result + '" type="button" class="button" value="Uppdatera" onclick="updateDog(' + result + ')"></form></div>');
                var msg = 'Du har lagt till ' + dogname + 's profil';
                showMessage(msg);
            }
            // Om hunden inte kunde läggas till i databasen skrivs ett felmeddelande ut
            else {
                $('<p class="errorMessageBox">' + dogname + 's uppgifter kunde inte sparas</p>').insertAfter('#addDogButton');
            }
        });
    }
}
// Uppdaterar en specifik hunds uppgifter efter klick på "Uppdatera", efter att formuläret validerats
function updateDog(dogId) {
    // Radera ev. meddelanden
    $(".errorMessageBox").remove();
    $('.successMessage').remove();
    // Skapa variabler
    var dogname = $('#dogname' + dogId).val();
    var dob = $('#dob' + dogId).val();
    var dogInfo = $('#dogInfo' + dogId).val();
    // Validerar hundinformationen genom funktionen validateDogInfo()
    var hasError = validateDogInfo(dogId, dogname, dob, dogInfo);
    // Om inga fel hittas görs ett AJAX-anrop för att uppdatera hundens uppgifter i databasen
    if (hasError == false) {
        $.ajax({
            method: 'POST',
            url: 'ajax/updateDog.php',
            data: {
                dogId: dogId,
                dogname: dogname,
                dob: dob,
                dogInfo: dogInfo
            }
        }).done(function(result) {
            // Om hundens uppgifter har uppdaterats skrivs ett meddelande ut genom funktionen showMessage()
            if (result == true) {
                $('#dognameTitle').html(dogname);
                var msg = dogname + 's uppgifter har uppdaterats';
                showMessage(msg);
            }
            // Om hundens uppgifter inte kunde uppdateras skrivs ett felmeddelande ut
            else {
                $('<p class="errorMessageBox">' + dogname + 's uppgifter kunde inte uppdateras</p>').insertAfter('#dogButton' + dogId);
            }
        });
    }
}
// Kollar om användaren verkligen vill radera hund, om JA så raderas hunden från databasen
function deleteDog(dogId, dogname) {
    /* Kollar om användaren tryckt på JA */
    if (confirm("Är du säker på att du vill radera " + dogname + "s uppgifter?") == true) {
        // AJAX_anrop som raderar hunden från databasen
        $.ajax({
            method: 'POST',
            url: 'ajax/deleteDog.php',
            data: {
                dogId: dogId,
            }
        }).done(function(result) {
            // Om raderingen lyckades tas dess information bort och ett meddelande skrivs ut genom funktionen showMessage()
            if (result == true) {
                $('#dogContainer_' + dogId).remove();
                var msg = dogname + 's uppgifter har raderats';
                showMessage(msg);
            }
            // Om hunden inte kunde raderas skrivs ett felmeddelande ut
            else {
                $('<p class="errorMessageBox">' + result + '</p>').insertAfter('#oldStudents');
            }
        });
    }
}
// Validerar hundinformation
function validateDogInfo(dogId, dogname, dob, dogInfo) {
    var hasError = false;
    // Kollar om namnfältet är tomt
    if (dogname == '') {
        $('<p class="errorMessageBox">Du måste fylla i hundens namn</p>').insertAfter('#dogname' + dogId);
        hasError = true;
    }
    // Kollar om födelsedatum fyllts i
    if (dob == '') {
        $('<p class="errorMessageBox">Du måste fylla i hundens födelsedatum</p>').insertAfter('#dob' + dogId);
        hasError = true;
    }
    else {
        // Validerar datumformatet genom funktionen validateDate()
        if (validateDate(dob) != true) {
            $('<p class="errorMessageBox">Ogiltigt datumformat</p>').insertAfter('#dob' + dogId);
            hasError = true;
        }
    }
    // Kollar om något har skrivits om hunden
    if (dogInfo == '') {
        $('<p class="errorMessageBox">Du måste fylla i information om din hund</p>').insertAfter('#dogInfo' + dogId);
        hasError = true;
    }
    // Returnerar resultatet av hasError
    return hasError;
}

// Visar ett meddelande som försvinner efter 2s i fönstrets överkant
function showMessage(msg) {
    $('<div class="successMessage">' + msg + '</div>').insertBefore('#mainContainer').delay(2000).fadeOut(function(){
        $(this).remove(); 
    });
    // Hämtar in information om var på sidan användaren har sin överkant och bredden på #mainContainer
    var screenTop = $(document).scrollTop();
    var elwidth = $('#mainContainer').width();
    var styles = {
        position: 'absolute',
        top: screenTop,
        'width': elwidth+89
    };
    // Lägger till i css-reglerna ovan till classen successMessage
    $('.successMessage').css(styles);
    // Tar bort meddelandet vid klick
    $('.successMessage').click(function() {
        $('.successMessage').remove();
    });
}
// Validerar datumformat, returnera 'true' eller 'false'
function validateDate(date) {
  var regEx = /^\d{4}-\d{2}-\d{2}$/;
  return date.match(regEx) != null;
}
// Lägger til en 0:a om siffram som skickas in är mindre än 10 (används för datum och tid)
function addZero(i) {
    if (i < 10) {
        i = "0" + i;
    }
    return i;
}
// Hämtar aktuell datum och tid i formatet åååå-mm-dd hh:mm:ss
function getDatetime() {
    var dt = new Date();
    var dateFormated = dt.toISOString().substr(0,10);
    var h = addZero(dt.getHours());
    var m = addZero(dt.getMinutes());
    var s = addZero(dt.getSeconds());
    datetime = dateFormated + " " + h + ":" + m + ":" + s;
    return datetime;
}