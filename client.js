var xhr = new XMLHttpRequest();
xhr.open('GET', 'http://localhost/lab10_yvts/client.php', true);
xhr.send(null);
xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 200) {
        var result = xhr.responseText;
        document.getElementById('search').innerHTML = result;
    }
};
fetch('http://localhost/lab10_yvts/client.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('search').innerHTML = data;
    })
    .catch(error => console.error(error));

$.ajax({
    url: 'http://localhost/lab10_yvts/client.php',
    type: 'GET',
    success: function(data) {
        document.getElementById('search').innerHTML = data;
    },
    error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
    }
});
    
