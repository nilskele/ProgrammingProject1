$(document).ready(function () {
    $("#wijzigButton").click(function () {
        let categoryId = $("#categoryName").val();
        let nieuweNaam = $("#nieuweNaam").val();

        if (categoryId === "" || nieuweNaam === "") {
            Swal.fire({
                icon: "warning",
                title: "Waarschuwing!",
                text: "Gelieve alle velden in te vullen.",
            });
            return;
        }

        Swal.fire({
            title: "Weet je het zeker?",
            text: "Weet je zeker dat je deze categorie wilt wijzigen?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, wijzig categorie!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "category_wijzigen_backend.php",
                    data: { cat_id: categoryId, nieuweNaam: nieuweNaam },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Succesvol gewijzigd!",
                            text: "De categorie is succesvol gewijzigd.",
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Fout!",
                            text: "Er is een fout opgetreden tijdens het wijzigen van de categorie.",
                        });
                    },
                });
            }
        });
    });

    $("#verwijderButton").click(function () {
        let categoryId = $("#categoryName").val();

        if (categoryId === "") {
            Swal.fire({
                icon: "warning",
                title: "Waarschuwing!",
                text: "Gelieve een categorie te selecteren.",
            });
            return;
        }

        Swal.fire({
            title: "Weet je het zeker?",
            text: "Weet je zeker dat je deze categorie wilt verwijderen?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, verwijder categorie!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "category_verwijderen_backend.php",
                    data: { cat_id: categoryId },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Succesvol verwijderd!",
                            text: "De categorie is succesvol verwijderd.",
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Fout!",
                            text: "Er is een fout opgetreden tijdens het verwijderen van de categorie.",
                        });
                    },
                });
            }
        });
    });

    $("#toevoegenCategory").click(function () {
        let categoryNameInput = $("#categoryNameInput").val();

        if (categoryNameInput === "") {
            Swal.fire({
                icon: "warning",
                title: "Waarschuwing!",
                text: "Gelieve een categorie in te vullen.",
            });
            return;
        }

        Swal.fire({
            title: "Weet je het zeker?",
            text: "Weet je zeker dat je deze categorie wilt toevoegen?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ja, voeg categorie toe!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "category_toevoegen_backend.php",
                    data: { categoryNameInput: categoryNameInput },
                    success: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Succesvol toegevoegd!",
                            text: "De categorie is succesvol toegevoegd.",
                        }).then((result) => {
                            location.reload();
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: "error",
                            title: "Fout!",
                            text: "Er is een fout opgetreden tijdens het toevoegen van de categorie.",
                        });
                    },
                });
            }
        });
    })
});
