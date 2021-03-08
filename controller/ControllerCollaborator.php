<?php

require_once "autoload.php";

class ControllerCollaborator extends EController {

    public function index() {
        $this->redirect();
    }

    public function add() {
        $board = $this->get_object_or_redirect("board_id", "Board");
        $this->authorize_for_board_or_redirect($board, false);

        $collaborator = $this->get_object_or_redirect("collab_id", "User");
        $board->add_collaborator($collaborator);

        $this->redirect("board", "collaborators", $board->get_id());
    }

    public function remove() {
        $board = $this->get_object_or_redirect("board_id", "Board");
        $this->authorize_for_board_or_redirect($board, false);

        $collaborator = $this->get_object_or_redirect("collab_id", "User");
        $board->remove_collaborator($collaborator);

        $this->redirect("board", "collaborators", $board->get_id());
    }
}