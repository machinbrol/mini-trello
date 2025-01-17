<?php namespace model;

require_once "tests/tools/DB.php";

use \ColumnDao;
use \CardDao;
use \BoardDao;
use \CommentDao;
use \User;
use \Board;
use \Column;
use \Card;
use \Comment;
use \tools\DB;
use \UserDao;


class CacheTest extends \PHPUnit\Framework\TestCase {
    public static DB $db;

    public static function setUpBeforeClass(): void {
        self::$db = new DB();
        self::$db->init();
    }

    public static function tearDownAfterClass(): void {
        self::$db->init();
    }

    public function testGetByIdOnDifferentClassesReturnsInstancesOfRightClass() {
        $user = UserDao::get_by_id(1);
        $board = BoardDao::get_by_id(1);
        $column = ColumnDao::get_by_id(1);
        $card = CardDao::get_by_id(1);
        $comment = CommentDao::get_by_id(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(Board::class, $board);
        $this->assertInstanceOf(Column::class, $column);
        $this->assertInstanceOf(Card::class, $card);
        $this->assertInstanceOf(Comment::class, $comment);

    }

    public function testMultipleBoardGetByIDReturnsSameInstance() {
        $board = ColumnDao::get_by_id(1);

        $this->assertNotEquals("!", $board->get_title());
        $board->set_title("!");  //n'est pas update en DB

        $board2 = ColumnDao::get_by_id(1);  // sans cache retournerait une nouvelle instance depuis la DB avec le titre original
        $this->assertSame($board, $board2);

        $this->assertEquals($board->get_title(), $board2->get_title());
    }

    public function testGetByIdInexistentIdReturnsNull() {
        $board = ColumnDao::get_by_id(42);
        $this->assertNull($board);
    }

    public function testMultipleGetByIdInexistentIDReturnsNull() {
        $board = ColumnDao::get_by_id(42);
        $board = ColumnDao::get_by_id(42);
        $this->assertNull($board);
    }

    public function testGetColumnsGetCardsGetCommentsReturnsCached() {
        $columns = BoardDao::get_by_id(1)->get_columns();
        $cards = ColumnDao::get_by_id(1)->get_cards();
        $comments = CardDao::get_by_id(6)->get_comments();


        $this->assertNotEquals("-", $columns[0]->get_title());
        $this->assertNotEquals("?", $cards[0]->get_title());
        $this->assertNotEquals("!", $comments[0]->get_body());

        //Pas sauvegardé en DB
        $columns[0]->set_title("-");
        $cards[0]->set_title("?");
        $comments[0]->set_body("!");

        $columns = BoardDao::get_by_id(1)->get_columns();
        $cards = ColumnDao::get_by_id(1)->get_cards();
        $comments = CardDao::get_by_id(6)->get_comments();

        //Comme pas sauvegardé, si valeurs identiques c'est que vient de cache
        $this->assertEquals("-", $columns[0]->get_title());
        $this->assertEquals("?", $cards[0]->get_title());
        $this->assertEquals("!", $comments[0]->get_body());
    }

}