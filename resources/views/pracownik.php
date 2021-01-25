<html>

    <head>

        <title>Strona glowna - Diamond Holdings</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- responsywnosc -->
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css"> <!-- ikony -->
        <link rel="stylesheet" href="css/bootstrap.min.css"> <!-- bootstrap -->
        <link rel="stylesheet" href="css/bootstrapLux.min.css"> <!-- bootstrap -->
        <link rel="stylesheet" type="text/css" href="css/style.css" /> <!-- style -->
        
    </head>
    <body>

    <?php include('komponenty/navbar_pracownik.php');?>

    <div class="container" style = "margin:0; width:100%; margin-top:10px;">
        <div class="row">
            
            <div class="col-lg-2"> </div>
            <div class="col-lg-8">

                <div class="row" style = "margin:2px;  width:70rem;"> <!-- historia -->
                    
                <h3>Operacje do weryfikacji</h3>
                
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                            <th scope="col"></th>
                            <th scope="col">Nadawca</th>
                            <th scope="col">Odbiorca</th>
                            <th scope="col">Kwota</th>
                            <th scope="col">Potwierdzenie</th>
                            </tr>
                        </thead>
                        <tbody>  <!-- tabela -->

                            <tr>
                            <th scope="row">1</th>
                            <td>Adam Adamski</td>
                            <td>Andrzej Andrzejowski</td>
                            <td>200,20 zł</td>
                            <td>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Tak</a>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Nie</a>
                            </td>
                            </tr>

                            <tr>
                            <th scope="row">2</th>
                            <td>Andrzej Andrzejowski</td>
                            <td>Karol Karolski</td>
                            <td>200,20 zł</td>
                            <td>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Tak</a>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Nie</a>
                            </td>
                            </tr>

                            <tr>
                            <th scope="row">3</th>
                            <td>Jan Janowski</td>
                            <td>Karol Karolski</td>
                            <td>200,20 zł</td>
                            <td>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Tak</a>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Nie</a>
                            </td>
                            </tr>

                            <tr>
                            <th scope="row">4</th>
                            <td>Damian Damianski</td>
                            <td>Jan Janowski</td>
                            <td>200,20 zł</td>
                            <td>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Tak</a>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Nie</a>
                            </td>
                            </tr>

                            <tr>
                            <th scope="row">5</th>
                            <td>Norbert Nrobercki</td>
                            <td>Jan Janowski</td>
                            <td>200,20 zł</td>
                            <td>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Tak</a>
                            <a class="btn btn-default btn-dark" href="#" role="button" style="width:42%;">Nie</a>
                            </td>
                            </tr>

                        </tbody>
                    </table> <!-- koniec tabeli -->

            <div class="col-lg-2"> </div>

        </div>
    </div>
    
    <script type="text/javascript" src="js/jquery.min.js"></script> <!-- jquery -->
    <script type="text/javascript" src="js/popper.min.js"></script> <!-- popper -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script> <!-- bootstrap -->

    </body>

</html>