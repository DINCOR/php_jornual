(function () {
    var picker = document.querySelector('.picker');
    var input = document.getElementById('task-search');
    var hidden = document.getElementById('task-id');
    var list = document.getElementById('task-results');
    var timer = null;
    var lastLabel = input.value;

    function render(items) {
        list.innerHTML = '';
        items.forEach(function (item) {
            var li = document.createElement('li');
            li.textContent = item.label;
            li.addEventListener('mousedown', function (event) {
                event.preventDefault();
                hidden.value = item.id;
                input.value = item.label;
                lastLabel = item.label;
                list.style.display = 'none';
            });
            list.appendChild(li);
        });
        list.style.display = items.length ? 'block' : 'none';
    }

    function load() {
        var url = picker.dataset.url + '?q=' + encodeURIComponent(input.value);
        fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
            .then(function (response) { return response.json(); })
            .then(render);
    }

    input.addEventListener('input', function () {
        hidden.value = '';
        clearTimeout(timer);
        timer = setTimeout(load, 250);
    });

    input.addEventListener('focus', load);

    input.addEventListener('blur', function () {
        list.style.display = 'none';
        if (!hidden.value) {
            input.value = '';
        } else {
            input.value = lastLabel;
        }
    });
})();
