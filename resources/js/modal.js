$("[id=openModal]").on("click",function(){
    modal = document.getElementById('modal');
    modal.classList.remove('hidden');
});

$("[class^=closeModal]").on("click",function(){
    modal = document.getElementById('modal');
    modal.classList.add('hidden');
});