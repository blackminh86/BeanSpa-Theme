/**
 * Simple collapse/accordion script for Beanspa sections.
 * Usage: Add class 'beanspa-collapse' to your <ul> or <div> container.
 * Each item should be <li> or <div> with a header (e.g. h3) and a content block.
 * Only one item is open at a time.
 */

export function initBeanspaCollapse(selector = '.beanspa-collapse') {
    document.querySelectorAll(selector).forEach(faqList => {
        faqList.querySelectorAll('li, .beanspa-collapse-item').forEach(item => {
            const header = item.querySelector('h3, .beanspa-collapse-header');
            if (header) {
                header.addEventListener('click', function () {
                    const isActive = item.classList.contains('active');
                    // Đóng tất cả
                    faqList.querySelectorAll('li, .beanspa-collapse-item').forEach(li => li.classList.remove('active'));
                    // Nếu chưa mở thì mở, nếu đang mở thì đóng
                    if (!isActive) {
                        item.classList.add('active');
                    }
                });
            }
        });
    });
}
