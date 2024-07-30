function agregarAlCarrito(producto, precio) {
    const formData = new FormData();
    formData.append('agregar', true);
    formData.append('producto', producto);
    formData.append('precio', precio);

    fetch('carrito.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); // Para depuración
        alert('Producto agregado al carrito');
    })
    .catch(error => {
        console.error('Error:', error);
    });
}