$(document).on("click", ".submit-form", function (e) {
    e.preventDefault();
    const url = $(this).attr("href");
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "question",
        showDenyButton: true,
        // showCancelButton: true,
        confirmButtonColor: "#3085d6",
        // cancelButtonColor: '#d33',
        confirmButtonText: "Yes, delete it!",
        denyButtonText: "Back",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        } else if (result.isDenied) {
            Swal.fire({
                title: "Changes are not made",
                icon: "info",
                timer: 1000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        }
    });
});
