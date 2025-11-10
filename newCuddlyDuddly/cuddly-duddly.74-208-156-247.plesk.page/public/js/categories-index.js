document.addEventListener('DOMContentLoaded', () => {
    // --- Tree toggle ---
    document.querySelectorAll('.tree-toggler').forEach(icon => {
        icon.addEventListener('click', () => {
            const parent = icon.closest('li');
            const nested = parent.querySelector('.nested');
            if (nested) {
                const expanded = icon.getAttribute('aria-expanded') === 'true';
                icon.setAttribute('aria-expanded', !expanded);
                nested.style.display = expanded ? 'none' : 'block';
                icon.classList.toggle('bi-chevron-right', expanded);
                icon.classList.toggle('bi-chevron-down', !expanded);
            }
        });
    });

    // --- Image upload ---
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', async e => {
            const file = e.target.files[0];
            if (!file) return;
            const id = e.target.dataset.id;
            const type = e.target.dataset.type;
            const progress = document.getElementById(`progress-${id}`);
            const preview = document.querySelector(`.preview-${id}`);

            const formData = new FormData();
            formData.append('id', id);
            formData.append('type', type);
            formData.append('image', file);

            progress.textContent = 'Uploading...';

            try {
                const res = await fetch(window.appRoutes.uploadImage, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: formData
                });

                const data = await res.json();
                if (data.success) {
                    preview.src = data.url;
                    progress.textContent = 'Done';
                } else {
                    progress.textContent = 'Failed';
                }
            } catch {
                progress.textContent = 'Error';
            }
        });
    });
});
