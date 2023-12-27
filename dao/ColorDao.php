<?php

class ColorDao
{

    private PDO $db_conn;

    public function __construct($db_conn)
    {
        $this->db_conn = $db_conn;
    }

    /**
     * @return Color[]
     */
    public function getAll() : array {
        $query_colors = "SELECT id FROM colors;";
        $stmt_colors = $this->db_conn->prepare($query_colors);
        $stmt_colors->execute();

        $result = $stmt_colors->fetchAll(PDO::FETCH_ASSOC);

        $colors_list = [];

        if ($result) {

            foreach ($result as $color_id) {
                array_push($colors_list, $this->getColorById((int) $color_id['id']));
            }

            return $colors_list;

        } else {
            throw new Exception("No user found in database");
        }
    }

    /**
     * @return Color
     */
    public function getColorById(int $color_id) : Color
    {
        $query_color = "SELECT * FROM colors WHERE id = :id";
        $stmt_color = $this->db_conn->prepare($query_color);
        $stmt_color->bindParam(':id', $color_id, PDO::PARAM_INT);
        $stmt_color->execute();

        $result_color = $stmt_color->fetch(PDO::FETCH_ASSOC);

        if($result_color) {
            return new Color($result_color['id'], $result_color['name']);
        } else {
            throw new Exception("Error al obtener el color por su ID");
        }
    }

}