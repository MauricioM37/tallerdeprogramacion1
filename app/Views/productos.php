<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/miestiloProductos.css">
    <script src="assets/js/app.js" async></script>
    <title>Tatu</title>
    <script src="assets/js/script.js"></script>
    
</head>
<body>
<script>
function actualizarTotalCarrito() {
    var carritoContenedor = document.querySelector('.carrito-items');
    var carritoItems = carritoContenedor.getElementsByClassName('carrito-item');
    var total = 0;

    for (var i = 0; i < carritoItems.length; i++) {
        var item = carritoItems[i];
        var precioElemento = item.querySelector('.carrito-item-precio');
        var cantidadElemento = item.querySelector('.carrito-item-cantidad');

        // 1. Elimina el símbolo $ y espacios
        var precioTexto = precioElemento.innerText.replace('$', '').trim();
        
        // 2. Reemplaza puntos (separadores de miles) y convierte comas a punto decimal
        precioTexto = precioTexto.replace(/\./g, '').replace(',', '.');
        
        // 3. Convierte a número
        var precio = parseFloat(precioTexto);
        var cantidad = parseInt(cantidadElemento.value) || 0;

        // 4. Suma al total (sin dividir ni multiplicar)
        total += precio * cantidad / 2;
    }

    // Formatea como pesos argentinos (2 decimales)
    var formatter = new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS',
        minimumFractionDigits: 3,
        maximumFractionDigits: 3
    });

    // Actualiza el HTML
    document.querySelector('.carrito-precio-total').innerText = formatter.format(total);
    document.getElementById('subtotalInput').value = total.toFixed(2); // Guarda el valor numérico
    return total;
}

    function TotalCarrito() {
    let carritoContenedor = document.querySelector('.carrito-items');
    let carritoItems = carritoContenedor.getElementsByClassName('carrito-item');
    let total = 0;
    let precio = 0 ;
    let cantidad = 0;
    let productos = [];
    for (var i = 0; i < carritoItems.length; i++) {
        let item = carritoItems[i];
        let precioElemento = item.querySelector('.carrito-item-precio');
        let cantidadElemento = item.querySelector('.carrito-item-cantidad');

        let precioTexto = precioElemento.innerText.replace('$', '').replace(/\./g, '').replace(',', '.');
         precio = parseFloat(precioTexto);
         cantidad = parseInt(cantidadElemento.value);

        productos.push({item,precio,cantidad});

        total += (precio * cantidad / 2);
    }
    
    let carrito = {
        productos,
        total
    }

    return carrito;
}

function enviarCarrito(event) {
    event.preventDefault();
    
    const carrito = TotalCarrito();
    const form = document.getElementById('form-pago');
    
    // Crear input hidden para los productos
    /*const inputProductos = document.createElement('input');
    inputProductos.type = 'hidden';
    inputProductos.name = 'productos';
    inputProductos.value = JSON.stringify(carrito.productos);
    form.appendChild(inputProductos);*/

    const productosInput = document.getElementById('productosInput');
    productosInput.value = JSON.stringify(carrito.productos);
    // Actualizar subtotal
    document.getElementById('subtotalInput').value = carrito.total.toFixed(2);
    
    // Enviar formulario
    form.submit();
}

document.addEventListener('DOMContentLoaded', function() {
    const btnIniciarPago = document.getElementById('btn-iniciar-pago');
    const formPago = document.getElementById('form-pago');
    
    if (btnIniciarPago && formPago) {
        btnIniciarPago.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Preparar datos del carrito
            const carrito = TotalCarrito();
            document.getElementById('subtotalInput').value = carrito.total;
            document.getElementById('productosInput').value = JSON.stringify(carrito.productos);
            
            // Ocultar botón y mostrar formulario
            btnIniciarPago.style.display = 'none';
            formPago.style.display = 'block';
            
            // Scroll automático al formulario
            formPago.scrollIntoView({ behavior: 'smooth' });
        });
    }});
</script>

<div class="titulo-contactos">
    <h2>Venta de productos</h2>
</div>  
<section class="contenedor">
    <div class="contenedor-items">
    <?php foreach ($tipos as $producto): ?>
    <?php if ($producto['activo'] == true) { ?> 
        <div class="item">
            <span class="titulo-item"><?php echo $producto['nombre']; ?></span>
            <img src="<?php echo base_url($producto['imagen']) ?>" alt="imagen producto" class="img-item">
            <span class="precio-item">$<?php echo number_format($producto['precio'], 2); ?></span>
            <span class="stock-item" style="display:none;"><?php echo $producto['salidas_diarias']; ?> salidas diarias</span>
            <span class="stock-min-item" style="display:none;"><?php echo $producto['salidas_disponibles']; ?>salidas disponibles</span>
            <button class="boton-item" data-id="<?php echo $producto['tipo_envio_id']; ?>">Agregar al Carrito</button>
            
        </div>
    <?php } ?>
<?php endforeach; ?>
    </div>

<div class="carrito" id="carrito">
    <div class="header-carrito">
        <h2>Carrito</h2>
    </div>

    <div class="carrito-items"></div>
    <div class="carrito-total">
        <div class="fila">
            <strong>Total</strong>
            <span class="carrito-precio-total">$0,00</span> 
        </div>
        
        <?php if (session()->get('is_logged')) : ?>
            <!-- Botón inicial para mostrar formulario -->
            <button id="btn-iniciar-pago" class="btn-pagar">
                Pagar <i class="fa-solid fa-bag-shopping"></i>
            </button>
            
            <!-- Formulario oculto inicialmente -->
            <form id="form-pago" method="post" action="<?= base_url('ventas-ad') ?>" style="display: none;">
                <input type="hidden" name="subtotal" id="subtotalInput" value="">
                <input type="hidden" name="productos" id="productosInput" value="">
                <input type="hidden" name="fecha" value="<?= date('Y-m-d H:i:s') ?>">
                
                <!-- Sección de información de envío -->
                <div class="formulario-envio">
                    <h4>Información de Envío</h4>
                    
                    <div class="form-group">
                        <label>Información adicional</label>
                        <textarea name="informacion_envio" class="form-control"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha inicio</label>
                            <input type="date" name="fecha_inicio" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Fecha llegada estimada</label>
                            <input type="date" name="fecha_llegada" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Destinatario</label>
                        <input type="text" name="destinatario_nombre" class="form-control" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label>Teléfono</label>
                            <input type="tel" name="destinatario_telefono" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>Dirección</label>
                            <input type="text" name="destinatario_direccion" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Localidad</label>
                        <input type="text" name="destinatario_localidad" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn-pagar">
                        Confirmar Envío <i class="fa-solid fa-check"></i>
                    </button>
                </div>
            </form>
        <?php else : ?>
            <a href="<?= base_url('login') ?>" class="btn-pagar">
                Inicie sesión para pagar <i class="fa-solid fa-bag-shopping"></i>
            </a>
        <?php endif; ?>
    </div>
</div>
</section>

<div class= "titulo-contactos">
    <h2>Preguntas frecuentes</h2>
</div>
<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Necesito asesoramiento para realizar una compra
            </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Si necesitas asesoramiento no dudes en avisarnos</strong> No dudes en seleccionar contactos, y mandar un email para ser rápidamente contestado!
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Cómo realizo una compra
            </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Para realizar una compra</strong> Debes seleccionar el producto que quieras, y se agregará automáticamente al carrito!
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Quiero consultar stock
            </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <strong>Para consultar stock es muy fácil</strostrong> Debes mandar un correo al sitio de contacto para confirmar si hay stock!
                
            </div>
        </div>
    </div>
</div>
</body>
<script>

    
</script>
</html>
