document.addEventListener('DOMContentLoaded', function () {
    const serviceModal = document.getElementById('serviceModal');
    const deleteModal = document.getElementById('deleteModal');

    if (serviceModal && deleteModal) {
        serviceModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const modalBody = serviceModal.querySelector('.modal-body');

            if (url && modalBody) {
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        modalBody.innerHTML = html;
                        const formElement = modalBody.querySelector('form');
                        if (formElement) {
                            formElement.setAttribute('action', url);
                        }
                    })
                    .catch(error => console.error('Error loading form:', error));
            }
        });

        serviceModal.addEventListener('submit', function (event) {
            event.preventDefault();
            const form = event.target;
            const action = form.getAttribute('action');

            fetch(action, {
                method: form.method,
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(serviceModal);
                        modal.hide();
                        window.location.reload();
                    } else {
                        console.error('Error submitting form:', data.error);
                    }
                })
                .catch(error => console.error('Error submitting form:', error));
        });

        deleteModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const url = button.getAttribute('data-url');
            const deleteForm = deleteModal.querySelector('form');

            if (url && deleteForm) {
                deleteForm.setAttribute('action', url);
            }
        });

        deleteModal.addEventListener('submit', function (event) {
            event.preventDefault();
            const form = event.target;
            const action = form.getAttribute('action');

            fetch(action, {
                method: form.method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ deleted: true })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getInstance(deleteModal);
                        modal.hide();
                        window.location.reload();
                    } else {
                        console.error('Error deleting service:', data.error);
                    }
                })
                .catch(error => console.error('Error deleting service:', error));
        });
    }

    const categoryLinks = document.querySelectorAll('.category-link');
    const services = document.querySelectorAll('.service-item');
    const searchInput = document.getElementById('searchInput');

    if (categoryLinks.length > 0 && services.length > 0) {
        function filterServices(selectedCategory, searchText) {
            services.forEach(service => {
                const serviceCategoryElement = service.querySelector('p:nth-of-type(2)');
                const serviceCategory = serviceCategoryElement ? serviceCategoryElement.dataset.category : '';
                const serviceName = service.querySelector('h3').textContent.trim().toLowerCase();
                const matchesCategory = selectedCategory === 'all' || serviceCategory === selectedCategory;
                const matchesSearch = serviceName.includes(searchText.toLowerCase());

                service.style.display = (matchesCategory && matchesSearch) ? 'block' : 'none';
            });
        }

        categoryLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                categoryLinks.forEach(link => link.classList.remove('active'));
                this.classList.add('active');
                const selectedCategory = this.getAttribute('data-category');
                filterServices(selectedCategory, searchInput.value);
            });
        });

        searchInput.addEventListener('input', function () {
            const selectedCategory = document.querySelector('.category-link.active')?.getAttribute('data-category') || 'all';
            filterServices(selectedCategory, this.value);
        });

        filterServices('all', '');
    }

    const scrollToTopBtn = document.getElementById('scrollToTopBtn');

    if (scrollToTopBtn) {
        window.addEventListener('scroll', function() {
            scrollToTopBtn.style.display = window.scrollY > 300 ? 'block' : 'none';
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
