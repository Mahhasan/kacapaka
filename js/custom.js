/*js for Featurs and offer Section */
document.addEventListener('DOMContentLoaded', function() {
    const elements = document.querySelectorAll('.break-words');
    elements.forEach(element => {
        const words = element.innerText.split(' ');
        element.innerHTML = words.map(word => `<span class="word">${word}</span>`).join('');
    });
});
