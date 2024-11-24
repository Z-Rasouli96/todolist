<?php
    require 'db.php';

class TodoClass extends Db{

    public function addTodo($title)
    {
        
        $todoSql = "INSERT INTO todos(title)VALUE(:title)";
        $todoexc = $this->connect()->prepare($todoSql);
        $todoexc->bindParam(':title', $title); 
        return $todoexc->execute();

    }

    public function allTodos()
    {
        $todosql = "SELECT * FROM todos ORDER BY id Desc";
        $todoexc = $this->connect()->prepare($todosql);
        $todoexc->execute();
        $todo = $todoexc->fetchAll();
        return $todo;
    }

    public function deleteTodo($id)
    {
       $todoSql = "DELETE FROM todos WHERE id = ?";
       $todoexc = $this->connect()->prepare($todoSql);
       $todo = $todoexc->execute([$id]);
       return $todo;
    }

    public function updateTodo($id,$title)
    {
        $todoSql = "UPDATE todos SET title = ? WHERE id = ?";
        $todoexc = $this->connect()->prepare($todoSql);
        return $todoexc->execute([$title, $id]);
    }

}
