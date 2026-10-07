
		<?php

			class Categories extends Controller {

				private $categoryModel;

				public function __construct() {
					// Redirigir a login si no está autenticado
					if (!isLoggedIn()) {
						header('Location: ' . urlRoot . '/users/login');

					}
					$this->categoryModel = $this->model('Category');
				}

				// Muestra la lista principal de categorías
				public function index() {
					$categories = $this->categoryModel->getCategories();
					$data = [
						'title' => 'Gestión de Categorías',
						'categories' => $categories
					];
					$this->view('categories/index', $data);
				}

				// Vista y procesamiento para crear categoría
				public function create() {
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

						$data = [
							'name' => trim($_POST['txtNombre']),
							'description' => trim($_POST['txtDescrip']),
							'imagen' => null,
							'mime' => null,
							'name_err' => ''
						];

						if (empty($data['name'])) {
							$data['name_err'] = 'Por favor ingrese el nombre de la categoría';
						}

						// Procesar la imagen si fue subida
						if (isset($_FILES['txtArchi']) && $_FILES['txtArchi']['error'] === UPLOAD_ERR_OK) {
							$data['imagen'] = file_get_contents($_FILES['txtArchi']['tmp_name']);
							$data['mime'] = $_FILES['txtArchi']['type'];
						}

						if (empty($data['name_err'])) {
							if ($this->categoryModel->addCategory($data)) {
								header('Location: ' . urlRoot . '/categories');
								exit();
							} else {
								die('Error al guardar la categoría.');
							}
						} else {
							$this->view('categories/inscateg', $data);
						}
					} else {
						$data = [
							'name' => '',
							'description' => '',
							'name_err' => ''
						];
						$this->view('categories/inscateg', $data);
					}
				}

				// Vista y procesamiento para modificar categoría
				public function edit($id) {
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

						$data = [
							'id' => $id,
							'name' => trim($_POST['txtNombre']),
							'description' => trim($_POST['txtDescrip']),
							'imagen' => null,
							'mime' => null,
							'name_err' => ''
						];

						if (empty($data['name'])) {
							$data['name_err'] = 'El nombre no puede estar vacío';
						}

						if (isset($_FILES['txtArchi']) && $_FILES['txtArchi']['error'] === UPLOAD_ERR_OK) {
							$data['imagen'] = file_get_contents($_FILES['txtArchi']['tmp_name']);
							$data['mime'] = $_FILES['txtArchi']['type'];
						}

						if (empty($data['name_err'])) {
							if ($this->categoryModel->updateCategory($data)) {
								header('Location: ' . urlRoot . '/categories');
								exit();
							} else {
								die('Error al actualizar.');
							}
						} else {
							$this->view('categories/modcateg', $data);
						}
					} else {
						$category = $this->categoryModel->getCategoryById($id);
						$data = [
							'id' => $category->CategoryID,
							'name' => $category->CategoryName,
							'description' => $category->Description,
							'has_image' => !empty($category->Imagen),
							'name_err' => ''
						];
						$this->view('categories/modcateg', $data);
					}
				}

				// Método para servir la imagen BLOB directamente con sus cabeceras HTTP
				public function image($id) {

$category = $this->categoryModel->getCategoryById($id);

if ($category && !empty($category->Imagen)) {

// Limpiar cualquier salida previa
if (ob_get_length()) {
ob_clean();
}

// Indicar al navegador qué tipo de archivo recibirá
header('Content-Type: ' . $category->Mime);
header('Content-Length: ' . strlen($category->Imagen));
header('Cache-Control: public, max-age=86400');

// Enviar únicamente la imagen
echo $category->Imagen;
exit();

} else {

http_response_code(404);
exit('Imagen no encontrada');
}
}
				// Eliminar categoría
				public function delete($id) {
					if ($_SERVER['REQUEST_METHOD'] === 'POST') {
						if ($this->categoryModel->deleteCategory($id)) {
							header('Location: ' . urlRoot . '/categories');
							exit();
						}
					}
				}
			}	
			
		?>
	
