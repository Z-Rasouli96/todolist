<?php 
require 'class/TodoClass.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="src/output.css" rel="stylesheet">
    <title>Document</title>
    <style>
        .strikethrough {
        text-decoration: line-through;
        color: lightgray;
        }
    
    </style>
</head>
<body class="font-mono">
    <div class="flex justify-center m-auto mt-5 text-4xl font-extrabold ...">
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-pink-400 to-blue-500">
            Todo lis
        </span>
    </div>

<div class="flex justify-center m-auto shadow-lg mt-5 mb-10 rounded">
    <div class="mt-5 mb-5 relative h-screen overflow-hidden">
       
        <form action="" method="POST">
            <div class="flex mb-8">
                <input type="text" name="title" dir="ltr"  class="rounded-s-lg inline-block m-0 text-sm p-3 bg-gray-200 focus:outline-none placeholder-purple-500 placeholder-opacity-100" placeholder=" Enter your todo">
                
                <button type="submit" name="submit" dir="rtl" class="bg-gradient-to-r from-cyan-500 to-blue-500 rounded-s-lg inline-block m-0 text-sm text-slate-300 p-3 w-24 hover:from-via-sky-700 hover:to-emerald-400"> Add todo </button>
            </div>
        </form>
        <?php
            $todo = new TodoClass();
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            if (!empty($title)) {
                $todo->addTodo($title);
            }

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $todo->deleteTodo($id);
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }


        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $id = $_POST['id'];
            $title = $_POST['title'];

            if (!empty($id) && !empty($title)) {
                if ($todo->updateTodo($id, $title)) {
                    echo "<p style='color:green;'>Todo updated successfully!</p>";
                    
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo "<p style='color:red;'>Failed to update the todo.</p>";
                }
            } else {
                echo "<p style='color:red;'>Please fill all fields.</p>";
            }
        }


        ?>
        <div class="overflow-y-scroll max-h-60 shadow-md rounded-lg p-4 bg-gray-200">
        <?php

        $todos = $todo->allTodos();
        foreach ($todos as $text) {
        ?>
            <div class="flex justify-between mt-3 bg-gray-400 rounded px-2">
            <div>
            <input type="checkbox" onclick="toggleStrike(this)" id="checkbox-<?php echo $text['id']; ?>" class="fa-regular fa-square-check">
                <span id="text-<?php echo $text['id']; ?>">
                <a href="#" 
                onclick="updateTodo(<?php echo $text['id']; ?>, '<?php echo $text['title']; ?>'); return false;" 
                class="text-gray-800 hover:underline">
                    <?php echo htmlspecialchars($text['title']); ?>
                </a>
            </span>
            </div>
            <div>
                <a href="?delete=<?php echo $text['id']; ?>">
                    <i class="fa-solid fa-trash"></i>
                </a>
            </div>
        </div>
        <?php
        }
        ?>

</div>

</div>

</div>


<div id="authentication-modal" tabindex="-1" aria-hidden="true" 
    class="hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-full bg-gray-500 bg-opacity-80">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-600">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Todo
                </h3>
                <button type="button" 
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" 
                        onclick="closeModal()">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5">
                <form id="editForm" class="space-y-4" method="POST" action="">
                    <input type="hidden" name="id" id="editId">
                    <div>
                        <label for="editTitle" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Title of Todo
                        </label>
                        <input type="text" name="title" id="editTitle" 
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:outline-none block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    <button type="submit" name="update" 
                            class="w-full text-white bg-gradient-to-r from-cyan-500 to-blue-500  font-medium rounded-lg text-sm px-5 py-2.5 text-center hover:from-via-sky-500 hover:to-emerald-400 ">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
function updateTodo(id, title) {

    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = title;

    const modal = document.getElementById('authentication-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal() {
    const modal = document.getElementById('authentication-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}


function toggleStrike(checkbox) {
    const textId = checkbox.id.replace('checkbox-', 'text-');
    const textElement = document.getElementById(textId);

    if (textElement) { 
        if (checkbox.checked) {
            textElement.classList.add('strikethrough');
        } else {
            textElement.classList.remove('strikethrough');
        }
    } else {
        console.error("Element with id", textId, "not found!");
    }
}


</script>



</body>
</html>