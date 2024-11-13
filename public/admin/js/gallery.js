$(document).ready(function () {
    // Array gambar yang telah diupload
    var images = [
        { src: 'upload/img1.jpg', category: 'nature' },
        { src: 'upload/img2.jpg', category: 'animals' },
        { src: 'upload/img3.jpg', category: 'nature' },
        { src: 'upload/img4.jpg', category: 'animals' },
        { src: 'upload/img5.jpg', category: 'nature' }
    ];

    // Fungsi untuk memuat gambar ke dalam galeri
    function loadImages(filter) {
        $('#gallery').empty();
        var filteredImages = images.filter(function (image) {
            return filter === 'all' || image.category === filter;
        });

        filteredImages.forEach(function (image) {
            $('#gallery').append(`
          <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card shadow-sm">
              <img src="${image.src}" class="card-img-top img-fluid gallery-img" alt="${image.category}">
            </div>
          </div>
        `);
        });
    }

    // Default: load all images
    loadImages('all');

    // Filter gambar berdasarkan kategori
    $('.filter-btn').click(function () {
        var filter = $(this).data('filter');
        loadImages(filter);

        $('.filter-btn').removeClass('btn-primary').addClass('btn-secondary');
        $(this).removeClass('btn-secondary').addClass('btn-primary');
    });

    // Efek hover pada gambar
    $(document).on('mouseenter', '.gallery-img', function () {
        $(this).css('transform', 'scale(1.1)');
    }).on('mouseleave', '.gallery-img', function () {
        $(this).css('transform', 'scale(1)');
    });

    // Tambahkan slider menggunakan Bootstrap Carousel saat gambar diklik
    $('#gallery').on('click', '.gallery-img', function () {
        var clickedImageSrc = $(this).attr('src');
        var carouselItemsHtml = '';

        images.forEach(function (image, index) {
            var isActive = image.src === clickedImageSrc ? 'active' : '';
            carouselItemsHtml += `
          <div class="carousel-item ${isActive}">
            <img src="${image.src}" class="d-block w-100" alt="${image.category}">
          </div>
        `;
        });

        // memasukkan gambar-gambar ke dalam carousel
        $('#carouselItems').html(carouselItemsHtml);

        // Tampilkan modal dengan carousel
        $('#imageModal').modal('show');
    });
});
