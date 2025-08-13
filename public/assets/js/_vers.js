// Récupérer le champ de montant
const montant = document.getElementById("amount");

// Formater le montant en ajoutant des espaces tous les 3 chiffres
function formatAmount(value) {
    value = value.replace(/\s+/g, '');
    return value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
}

montant.addEventListener('input', function(e) {
    e.target.value = formatAmount(e.target.value);
});

$(document).ready(function() {
    const form = $('.form_versement');
    const submitBtn = form.find('#btn_vers');
    const inputs = form.find('input');

    // Désactivation initiale du bouton d'envoi
    submitBtn.prop('disabled', true);

    inputs.on('keyup blur', function() {
        // Vérification si tous les champs sont remplis
        let tousRemplis = true;
        inputs.each(function() {
            if ($(this).val() === '') {
                tousRemplis = false;
            }
        });

        // Activation ou désactivation du bouton d'envoi en fonction de la vérification
        submitBtn.prop('disabled', !tousRemplis);
    });

    $('#compte').change(function() {
        const selectedValue = $("#compte option:selected").val();
        $('#num_generer').val(selectedValue);
    }).trigger('change');

    $("#addVersement").on('show.bs.modal', function() {
        const modal = $(this);

        let amount = $('#amount').val().replace(/\s/g, '');
        const cumulday = $('#cumulday').val().replace(/\s/g, '');
        const cumuldayFinal = parseFloat(cumulday) + parseFloat(amount);

        const nom_deposant = $('#nom_deposant').val();
        const tel_deposant = $('#tel_deposant').val();
        const motif_versement = $('#motif_versement').val();
        const num_generer = $('#num_generer').val();

        modal.find('#affiche_num_account').html(num_generer);
        modal.find('#num_account_select').val(num_generer);

        amount = formatAmount(amount); // Réutilisation de la fonction formatAmount pour afficher proprement
        modal.find('#affiche_amount').html(`${amount} BIF`);
        modal.find('#result_amount').val(amount.replace(/\s/g, ''));

        modal.find('#affiche_nom_deposant').html(nom_deposant);
        modal.find('#result_nom_deposant').val(nom_deposant);

        modal.find('#affiche_tel_deposant').html(tel_deposant);
        modal.find('#result_tel_deposant').val(tel_deposant);

        modal.find('#affiche_motif').html(motif_versement);
        modal.find('#result_motif_versement').val(motif_versement);

        if (cumuldayFinal > 20000000) {
            $('.alert').text('Cette opération nécessite une autorisation avant d\'être effectuée');
            $('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-danger btn-lg">Demander une autorisation</button>');
        } else {
            $('.alert').text('Bien vouloir vérifier le versement ci-après et cliquer sur le bouton de confirmation');
            $('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-success btn-lg">Confirmer et imprimer le versement></button>');
        }
    });
});
