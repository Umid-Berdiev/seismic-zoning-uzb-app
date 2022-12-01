import Swal from "sweetalert2";

export const useSwal = function () {
    let toast = Swal.mixin({
        buttonsStyling: false,
        target: "#page-container",
        customClass: {
            confirmButton: "btn btn-success m-1",
            cancelButton: "btn btn-danger m-1",
            input: "form-control",
        },
    });

    return toast;
};
