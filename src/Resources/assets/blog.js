document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('textarea[data-editor="jodit"]').forEach((el) => {
        // Si Jodit existe, mejora; si no, queda textarea.
        if (window.Jodit) new Jodit(el, { minHeight: 240 });
    });
});
