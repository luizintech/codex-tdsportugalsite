const txtTitle = $("#pageTitle");
const txtLink = $("#pageLink");

function slugify(text) {
    return text
        .toString()                     // garante que é string
        .normalize("NFD")                // remove acentos
        .replace(/[\u0300-\u036f]/g, "") // tira os diacríticos
        .toLowerCase()                   // tudo minúsculo
        .trim()                          // remove espaços extras no começo/fim
        .replace(/[^a-z0-9\s-]/g, "")    // remove caracteres especiais
        .replace(/\s+/g, "-")            // troca espaços por hífen
        .replace(/-+/g, "-");            // evita múltiplos hifens seguidos
}

txtTitle.on("input", function () {
    const slug = slugify($(this).val());
    txtLink.val(slug);
});

tinymce.init({
    selector: '#pageContent',
    plugins: 'code codesample image media link lists table',
    toolbar: 'code codesample image media link numlist bullist table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol'
});

let currentPage = 1;
let pageSize = 20;
let loading = false;

function loadMedias(reset = false) {
    if (loading) return;
    loading = true;

    if (reset) {
        currentPage = 1;
        $("#mediaContainer").html('<div class="text-center text-muted">Carregando imagens...</div>');
    }

    $.get(`${base_url}/painel/medias/list?page=${currentPage}&size=${pageSize}`, function (data) {
        if (reset) {
            $("#mediaContainer").empty();
        }

        if (!data.objectResult || data.objectResult.length === 0) {
            $("#loadMoreMedias").hide();
            if (reset) {
                $("#mediaContainer").html('<div class="text-center text-muted">Nenhuma imagem encontrada.</div>');
            }
            return;
        }

        data.objectResult.forEach(media => {
            let html = `
            <div class="col-md-3 mb-3 text-center">
                <img src="${base_url}/uploads/Medias/${media.image_url}" class="img-thumbnail media-option" 
                    data-id="${media.id}" data-name="${media.image_url}" 
                    style="cursor:pointer; max-height:120px; object-fit:cover;">
            </div>
            `;
            $("#mediaContainer").append(html);
        });

        currentPage++;
        $("#loadMoreMedias").show();
    }).always(() => loading = false);
}

$('#mediaModal').on('show.bs.modal', function () {
    loadMedias(true);
});

$("#loadMoreMedias").on("click", function () {
    loadMedias();
});

$(document).on("click", ".media-option", function() {
    let mediaId = $(this).data("id");
    let mediaName = $(this).data("name");

    $("#mediaId").val(mediaId);
    $("#mediaPreview").val(mediaName);

    $("#mediaModal").modal("hide");
});
