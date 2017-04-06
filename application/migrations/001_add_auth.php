<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Auth extends CI_Migration {

        public function up() {

                ###############
                # USERS TABLE #
                ###############

                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => 6,
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'username' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100',
                                'null' => TRUE,
                        ),
                        'email' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '100'
                        ),
                        'phone' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE
                        ),
                        'password' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '150',
                        ),
                        'salt' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '150',
                                'null' => TRUE,
                        ),
                        'name1' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE,
                        ),
                        'name2' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE,
                        ),
                        'lastname1' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE,
                        ),
                        'lastname2' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '30',
                                'null' => TRUE,
                        ),
                        'permissions' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'null' => TRUE,
                        ),
                        'activation_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '40',
                                'null' => TRUE
                        ),
                        'forgotten_password_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '60',
                                'null' => TRUE
                        ),
                        'is_active' => array(
                                'type' => 'TINYINT',
                                'constraint' => '1',
                                'unsigned' => TRUE,
                                'null' => TRUE
                        ),
                        'blocked_time' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE,
                        ),
                        'lastlogin_time' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE,
                        ),
                        'lastlogin_ip' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '15',
                                'null' => TRUE,
                        ),
                        'created_at' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE,
                        ),
                        'edited_at' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE,
                        ),

                ));
                // Adds the keys. TRUE for the primary key.
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->add_key('username');
                $this->dbforge->add_key('email');       
                // Creates the table. Second parameter TRUE creates it only if doesn't exist.
                $this->dbforge->create_table('users');

                #########################
                # LOGGIN ATTEMPTS TABLE #
                #########################

                $this->dbforge->add_field(array(
                        'id' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'auto_increment' => TRUE
                        ),
                        'ip_address' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '16'
                        ),
                        'user_id' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'null' => TRUE
                        ),
                        'status' => array(
                                'type' => 'INT',
                                'constraint' => '1',
                                'unsigned' => TRUE,
                                'null' => TRUE
                        ),
                        'created_at' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE
                        ),
                        'updated_at' => array(
                                'type' => 'INT',
                                'constraint' => '11',
                                'unsigned' => TRUE,
                                'null' => TRUE
                        )
                ));
                $this->dbforge->add_key('id', TRUE);
                $this->dbforge->create_table('login_attempts');
        }

        public function down() {
                $this->dbforge->drop_table('users');
                $this->dbforge->drop_table('login_attempts');
        }
}