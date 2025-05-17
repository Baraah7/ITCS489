// FAQ Accordion functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const isOpen = content.classList.contains('hidden');
            
            // Close all other FAQs
            document.querySelectorAll('.faq-content').forEach(item => {
                item.classList.add('hidden');
            });
            document.querySelectorAll('.faq-toggle span').forEach(icon => {
                icon.textContent = '+';
            });
            
            // Toggle current FAQ
            if (isOpen) {
                content.classList.remove('hidden');
                button.querySelector('span').textContent = '-';
            }
        });
    });
});
