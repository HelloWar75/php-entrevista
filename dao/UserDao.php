<?php

class UserDao
{
    private PDO $db_conn;

    public function __construct($db_conn)
    {
        $this->db_conn = $db_conn;
    }

    /**
     * @return User[]
     */
    public function getAll(): array
    {
        $query_users = "SELECT id FROM users;";
        $stmt_users = $this->db_conn->prepare($query_users);

        if ($stmt_users->execute()) {
            $result = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

            $users_list = [];

            foreach ($result as $user_id) {
                array_push($users_list, $this->getUserById((int) $user_id['id']));
            }

            return $users_list;

        } else {
            throw new Exception("Erro ao obter lista de usuários!");
        }


    }

    /**
     * @return User
     */
    public function getUserById(int $user_id): User
    {
        $colorDao = new ColorDao($this->db_conn);

        $query_user = "SELECT * FROM users WHERE id = :user_id LIMIT 1";
        $stmt_user = $this->db_conn->prepare($query_user);
        $stmt_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt_user->execute()) {
            $result_user = $stmt_user->fetch(PDO::FETCH_ASSOC);

            $user_colors = [];

            if ($result_user) {
                $query_user_colors = "SELECT * FROM user_colors WHERE user_id = :user_id";
                $stmt_user_colors = $this->db_conn->prepare($query_user_colors);
                $stmt_user_colors->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_user_colors->execute();

                $result_user_colors = $stmt_user_colors->fetchAll(PDO::FETCH_ASSOC);

                if ($result_user_colors) {
                    foreach ($result_user_colors as $color_id) {

                        $color = $colorDao->getColorById($color_id['color_id']);
                        array_push($user_colors, $color);

                    }
                }

                return new User($result_user['name'], $result_user['email'], $result_user['id'], $user_colors);
            } else {
                throw new Exception("Usuário não encontrado.");
            }
        } else {
            throw new Exception("Erro ao obter usuario no banco de dados.");
        }

    }

    public function insertColorForUserId(int $user_id, Color $color)
    {

        $color_id = (int) $color->getId();

        $insert_query = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
        $stmt_insert = $this->db_conn->prepare($insert_query);
        $stmt_insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_insert->bindParam(':color_id', $color_id, PDO::PARAM_INT);
        return $stmt_insert->execute();

    }

    public function deleteColorsForUserId(int $user_id)
    {
        $delete_query = "DELETE FROM user_colors WHERE user_id = :user_id";
        $stmt_delete = $this->db_conn->prepare($delete_query);
        $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        return $stmt_delete->execute();
    }

    public function update(User $user)
    {

        $name = (string) $user->getName();
        $email = (string) $user->getEmail();
        $user_id = (int) $user->getId();

        $update_query = "UPDATE users SET name = :name, email = :email WHERE id = :user_id";
        $stmt_update = $this->db_conn->prepare($update_query);
        $stmt_update->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            if ($this->deleteColorsForUserId($user_id)) {
                foreach ($user->getColors() as $color) {
                    if (!$this->insertColorForUserId($user_id, $color)) {
                        throw new Exception("Erro ao atualizar usuário no banco de dados (insertColorForUserId). ");
                    }
                }
            } else {
                throw new Exception("Erro ao atualizar usuário no banco de dados (deleteColorsForUserId). ");
            }
        } else {
            throw new Exception("Erro ao atualizar usuário no banco de dados");
        }

    }

    public function insert(User $user)
    {

        $name = (string) $user->getName();
        $email = (string) $user->getEmail();

        $insert_query = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt_insert = $this->db_conn->prepare($insert_query);
        $stmt_insert->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);

        if ($stmt_insert->execute()) {
            $user_id = $this->db_conn->lastInsertId();
            foreach ($user->getColors() as $color) {
                if (!$this->insertColorForUserId($user_id, $color)) {
                    throw new Exception("Erro ao inserir novo usuário no banco de dados (insertColorForUserId). ");
                }
            }
        } else {
            throw new Exception("Erro ao inserir novo usuário no banco de dados");
        }

    }

    public function delete(User $user)
    {

        $user_id = (int) $user->getId();

        if ($this->deleteColorsForUserId($user_id)) {
            $delete_query = "DELETE FROM users WHERE id = :user_id";
            $stmt_delete = $this->db_conn->prepare($delete_query);
            $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($stmt_delete->execute()) {
                return true;
            } else {
                throw new Exception("Erro ao deletar usuário do banco de dados.");
            }
        } else {
            throw new Exception("Erro ao deletar usuário do banco de dados (deleteColorsForUserId) .");
        }

    }

}