function souris_dessus(x) {
    x.classList.add('bg-body-secondary');
}
function souris_sort(x) {
    x.classList.remove('bg-body-secondary');
}
function envoie_formulaire(x) {
    console.log(x);
    document.getElementById(x).click();
}