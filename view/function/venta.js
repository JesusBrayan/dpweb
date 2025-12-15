let productos_venta = {};
let id = 2;
let id2 = 4;

let producto = {};
producto.nombre = "Producto A";
producto.precio = 100;
producto.cantidad = 2;

let producto2 = {};
producto2.nombre = "Producto B";
producto2.precio = 200;
producto2.cantidad = 1;
//productos_venta.push(producto);

productos_venta[id] = producto;
productos_venta[id2] = producto2;
console.log(productos_venta);

//splice remueve elementos, inserta nuevo elemento
/*productos_venta.splice(id,1);
console.log(productos_venta);*/


//agregar producto temporal
async function agregar_producto_temporal() {
    let id = document.getElementById('id_producto_venta').value;
    let precio = document.getElementById('producto_precio_venta').value;
    let cantidad = document.getElementById('producto_cantidad_venta').value;
    const datos = new FormData();
    datos.append('id_producto', id);
    datos.append('precio', precio);
    datos.append('cantidad', cantidad);
    
    try {
        let respuesta = await fetch(base_url + 'control/ventaController.php?tipo=registrar_temporal', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if (json.status) {
            // No mostrar alert nativo. Registrar en consola para depuración.
            console.log('agregar_producto_temporal:', json.msg);
        }

    } catch (error) {
        console.log("error" + error)
    }
}

// Función para buscar cliente por DNI
async function buscarCliente() {
    let dni = document.getElementById('cliente_dni').value;
    try {
        const datos = new FormData();
        datos.append('dni', dni);

        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=buscarCliente', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });

        json = await respuesta.json();
        if (json.status && json.data) {
            const data = json.data;
            let nombreCliente = '';
            if (data.razon_social) nombreCliente = data.razon_social;
            else if (data.nombre) nombreCliente = data.nombre;
            else if (data.nombres || data.apellidos || data.apellido) nombreCliente = `${data.nombres || ''} ${data.apellidos || data.apellido || ''}`.trim();
            // actualizar campos del modal
            const nombreEl = document.getElementById('cliente_nombre');
            const dniEl = document.getElementById('cliente_dni');
            if (nombreEl) nombreEl.value = nombreCliente || '';
            if (dniEl) dniEl.value = data.nro_identidad || dni;
        } else {
            alert("Cliente no encontrado");
            const nombreEl = document.getElementById('cliente_nombre');
            if (nombreEl) nombreEl.value = '';
        }
    } catch (error) {
        console.log("error al buscar cliente" + error);
    }
}


// Carga el usuario que inició sesión y lo muestra en el modal
async function cargarUsuarioSesion() {
    try {
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=usuario_sesion');
        let json = await respuesta.json();
        if (json.status) {
            if (document.getElementById('cliente_nombre')) document.getElementById('cliente_nombre').value = json.data.razon_social || '';
            if (document.getElementById('cliente_dni')) document.getElementById('cliente_dni').value = json.data.nro_identidad || '';
        }
    } catch (error) {
        console.log('Error al cargar usuario en sesión: ' + error);
    }
}

// Ejecutar al abrir el modal (Bootstrap)
try {
    let modalEl = document.getElementById('exampleModal');
    if (modalEl) modalEl.addEventListener('shown.bs.modal', cargarUsuarioSesion);
} catch (e) {
    console.log(e);
}


//registrar venta

async function registrarVenta() {
    let cliente_dni = document.getElementById('cliente_dni').value;
    let cliente_nombre = document.getElementById('cliente_nombre').value;
    let fecha_venta = document.getElementById('fecha_venta').value;
    
    if (cliente_dni == '' || cliente_nombre == '' || fecha_venta == '') {
        return alert("Debe completar los campos obligatorios");
    }
    
    try {
        const datos = new FormData();
        datos.append('cliente_dni', cliente_dni);
        datos.append('cliente_nombre', cliente_nombre);
        datos.append('fecha_venta', fecha_venta);
        
        let respuesta = await fetch(base_url + 'control/VentaController.php?tipo=registrar_venta', {
            method: 'POST',
            mode: 'cors',
            cache: 'no-cache',
            body: datos
        });
        json = await respuesta.json();
        if(json.status){
            alert("Venta registrada con éxito");
            // Limpiar formulario antes de recargar
            document.getElementById('cliente_dni').value = '';
            document.getElementById('cliente_nombre').value = '';
            document.getElementById('form_venta').reset();
            // Cerrar modal
            const modalEl = document.getElementById('exampleModal');
            if (modalEl) {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            window.location.reload();
        }else{
            alert("Error: " + json.msg);
        }

    } catch (error) {
        console.log("error al registrar venta: " + error);
        alert("Error al registrar venta: " + error);
    }
}