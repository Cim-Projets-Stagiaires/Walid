document
    .getElementById("etablissement")
    .addEventListener("change", function () {
        if (this.value === "Autre") {
            document.getElementById("autre-etablissement").style.display =
                "block";
        } else {
            document.getElementById("autre-etablissement").style.display =
                "none";
        }
    });

document
    .getElementById("type-de-stage")
    .addEventListener("change", function () {
        if (this.value === "Autres") {
            document.getElementById("autre-type-de-stage").style.display =
                "block";
        } else {
            document.getElementById("autre-type-de-stage").style.display =
                "none";
        }
    });

document
    .querySelectorAll('input[name="modalite_de_stage"]')
    .forEach((radio) => {
        radio.addEventListener("change", function () {
            const planningInput = document.getElementById("planning-mi-temps");
            if (this.value === "mi-temps") {
                planningInput.style.display = "block";
            } else {
                planningInput.style.display = "none";
            }
        });
    });

document.getElementById("cv-upload").addEventListener("change", function () {
    const cvFileName = document.getElementById("cv-file-name");
    cvFileName.textContent = this.files[0] ? this.files[0].name : "";
});

document
    .getElementById("cover-letter-upload")
    .addEventListener("change", function () {
        const coverLetterFileName = document.getElementById(
            "cover-letter-file-name"
        );
        coverLetterFileName.textContent = this.files[0]
            ? this.files[0].name
            : "";
    });

document
    .getElementById("insurance-upload")
    .addEventListener("change", function () {
        const coverLetterFileName = document.getElementById(
            "insurance-file-name"
        );
        coverLetterFileName.textContent = this.files[0]
            ? this.files[0].name
            : "";
    });

function showHideInput() {
    var etablissement = document.getElementById("etablissement").value;
    var typeDeStage = document.getElementById("type-de-stage").value;
    var modaliteDeStage = document.querySelector(
        'input[name="modalite_de_stage"]'
    ).value;

    document.getElementById("autre-etablissement").style.display =
        etablissement == "Autre" ? "block" : "none";
    document.getElementById("autre-type-de-stage").style.display =
        typeDeStage == "Autres" ? "block" : "none";
    document.getElementById("planning-mi-temps").style.display =
        modaliteDeStage == "mi-temps" ? "block" : "none";
}

document.addEventListener("DOMContentLoaded", function () {
    showHideInput();
    document
        .getElementById("etablissement")
        .addEventListener("change", showHideInput);
    document
        .getElementById("type-de-stage")
        .addEventListener("change", showHideInput);
    document
        .querySelectorAll('input[name="modalite_de_stage"]')
        .forEach((elem) => {
            elem.addEventListener("change", showHideInput);
        });
});

document.addEventListener("DOMContentLoaded", function () {
    // Handle delete modal
    var deleteModal = document.getElementById("deleteModal");
    deleteModal.addEventListener("show.bs.modal", function (event) {
        var button = event.relatedTarget;
        var demandeId = button.getAttribute("data-id");
        var form = deleteModal.querySelector("#deleteForm");
        var action = form.getAttribute("action");
        form.setAttribute("action", action + "/" + demandeId);
    });
    // Check if the modal should be shown
    var approveModal = document.getElementById("approveModal");
    if (approveModal) {
        var modal = new bootstrap.Modal(approveModal);
        modal.show();
    }
});

function viewCv() {
document.getElementById("cv").style.display = "block";
var div = document.getElementById("parent");
div.classList.add("overlay")
}

function viewDocument(url, title) {
    var modalTitle = document.getElementById('pdfModalLabel');
    var iframe = document.getElementById('pdfIframe');

    modalTitle.innerText = title;
    iframe.src = url;

    var pdfModal = new bootstrap.Modal(document.getElementById('pdfModal'));
    pdfModal.show();
}
