<x-app-layout>
    <!-- Carousel Wrapper -->
    <section class="flex items-center justify-center min-h-screen px-6 pb-16">
        <div
            id="carousel"
            class="flex overflow-x-auto space-x-8 snap-x snap-mandatory scroll-smooth px-12 py-6"
            style="scrollbar-width: none; -ms-overflow-style: none;"
        >
            @for ($i = 1; $i <= 9; $i++)
                <img
                    src="/images/product{{ $i }}.jpg"
                    class="carousel-item w-60 flex-shrink-0 rounded shadow-md transition-transform duration-300 snap-center"
                    alt="Product {{ $i }}"
                >
            @endfor
        </div>
    </section>

    <style>
        #carousel::-webkit-scrollbar {
            display: none;
        }

        .carousel-item.active {
            transform: scale(1.1);
            z-index: 10;
        }
    </style>

    <script>
    const carousel = document.getElementById('carousel');
    let isDragging = false, startX, scrollStart;

    // Mouse controls
    carousel.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX;
        scrollStart = carousel.scrollLeft;
        carousel.classList.add('cursor-grabbing');
    });

    carousel.addEventListener('mouseup', () => {
        isDragging = false;
        carousel.classList.remove('cursor-grabbing');
    });

    carousel.addEventListener('mouseleave', () => {
        isDragging = false;
        carousel.classList.remove('cursor-grabbing');
    });

    carousel.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const walk = (e.pageX - startX) * 1.5;
        carousel.scrollLeft = scrollStart - walk;
    });

    // Touch controls
    let touchStartX = 0;
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        scrollStart = carousel.scrollLeft;
    });

    carousel.addEventListener('touchmove', (e) => {
        const x = e.touches[0].clientX;
        const walk = (x - touchStartX) * 1.5;
        carousel.scrollLeft = scrollStart - walk;
    });

    // Highlight center image
    function highlightCenter() {
        const items = document.querySelectorAll('.carousel-item');
        const center = carousel.scrollLeft + carousel.offsetWidth / 2;

        items.forEach(item => {
            const box = item.getBoundingClientRect();
            const itemCenter = box.left + box.width / 2;

            if (Math.abs(itemCenter - window.innerWidth / 2) < box.width / 2) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    carousel.addEventListener('scroll', () => {
        requestAnimationFrame(highlightCenter);
    });

    // Initial trigger
    highlightCenter();
</script>

</x-app-layout>
