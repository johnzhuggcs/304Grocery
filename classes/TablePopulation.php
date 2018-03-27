<?php
/**
 * Created by PhpStorm.
 * User: johnz
 * Date: 2018-03-27
 * Time: 12:00 PM
 */

class TablePopulation
{
    private $SQLExecution;
    private $allCreateTables;

    function TablePopulation($sqlExecution){
        $this->SQLExecution = $sqlExecution;
        $this->allCreateTables = array(
            "create table product
          (pid char(5),
          price DOUBLE precision,
          expire_date DATE,
          ingredients CHAR(200),
          cfoot DOUBLE precision, 
          origin CHAR(20), 
          quantity INTEGER NOT NULL, 
          name CHAR(30) NOT NULL UNIQUE,
          brand CHAR(30) NOT NULL,
          description CHAR(100), 
          rpoint INTEGER,
          weight DOUBLE precision,
          allergies CHAR(200),
          volume DOUBLE precision,
          PRIMARY KEY (pid))",

          "CREATE TABLE Employee
          (Employee_ID CHAR(7),
          sin# INTEGER,
          PRIMARY KEY(Employee_ID),
          UNIQUE(sin#))",

            "CREATE TABLE Deal
            (shared_link CHAR(40),
            start_date CHAR(10),
            end_date CHAR(10),
            DID CHAR(5),
            discount CHAR(10),
            Premium_only BIT,
            PRIMARY KEY (DID),
            UNIQUE(shared_link))",

          "CREATE TABLE Manage
          (Deal_ID CHAR(5),
          Employee_ID CHAR(7),
          PRIMARY KEY (Deal_ID, Employee_ID),
          FOREIGN KEY (Deal_ID),
          REFERENCES Deal(DID),
          FOREIGN KEY (Employee_ID),
          REFERENCES Employee(Employee_ID),
          ON UPDATE CASCADE,
          ON DELETE SET NULL)",

            "CREATE TABLE product_discount
            (PID CHAR(5],
            DID CHAR(5],
            expire_date CHAR(10],
            price DOUBLE,
            Ingredients CHAR(200],
            origin CHAR(20],
            stock_quantity INTEGER,
            description CHAR(100],
            carbon_footprint DOUBLE[6, 2],
            reward_points INTEGER,
            PRIMARY KEY (PID),
            UNIQUE (name, brand),
            FOREIGN KEY (DID)
            REFERENCES Deal(DID)
            ON UPDATE CASCADE
            ON DELETE CASCADE)
            CREATE TABLE Food
            (PID CHAR(5],
            Weight DOUBLE[6, 2],
            Allergies CHAR(100],
            PRIMARY KEY (PID),
            FOREIGN KEY (PID)
            REFERENCES product_discount(PID)
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE Beverage
            (PID CHAR(5],
            Volume DOUBLE[6, 2),
            Allergies CHAR(100),
            PRIMARY KEY (PID),
            UNIQUE (Weight),
            FOREIGN KEY (PID)
            REFERENCES product_discount(PID)
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE Beverage
            (PID CHAR(5),
            Volume DOUBLE[6, 2],
            Allergies CHAR(100),
            PRIMARY KEY (PID),
            UNIQUE (Weight),
            FOREIGN KEY (PID)
            REFERENCES product_discount(PID)
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE Access_to
            (DID CHAR(5),
            Account_no. CAHR[5),
            PRIMARY KEY (DID,Account_no.)
            FOREIGN KEY (DID)
            REFERENCES Deal,
            ON UPDATE CASCADE
            ON DELETE CASCADE
            FOREIGN KEY (Account_no.)
            REFERENCES Customer
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE Customer
            (Name CHAR(20),
            Email CHAR(40),
            Reward Points INTEGER,
            Premium BIT,
            Account_no. CHAR(5),
            PRIMARY KEY(Account no))",

            "CREATE TABLE Contains
            (PID INTEGER,
            order no CHAR(7),
            PRIMARY KEY (PID,order no),
            FOREIGN KEY (PID)
            REFERENCES Product,
            ON UPDATE CASCADE
            ON DELETE CASCADE
            FOREIGN KEY (order no)
            REFERENCES Order
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE Order_placedby_shippedwith
            (order_no. CHAR(7),
            Date CHAR(10),
            Free_shipping BIT,
            Status CHAR(10),
            Order_total DOUBLE[9, 2],
            Payment_method CHAR(10),
            Poins_awarded INTEGER,
            Account_no. CHAR(5), NOT NULL
            Shipping_info_no. CHAR( 6), NOT NULL
            PRIMARY KEY (order_no.)
            FOREIGN KEY (Account_no.)
            REFERENCES Customer
            ON UPDATE CASCADE
            ON DELETE CASCADE
            FOREIGN KEY (shipping_info_no.)
            REFERENCES Shipping_Info
            ON UPDATE CASCADE
            ON DELETE CASCADE)",

            "CREATE TABLE owns
            (Account_no. CHAR(5),
            Shipping_info_no. CHAR(6),
            PRIMARY KEY (Account_no., Shipping_info_no.)
            FOREIGN KEY (Account_no)
            REFERENCES Customer,
            ON UPDATE CASCADE
            ON DELETE ON CASCADE
            FOREIGN KEY (Shipping_info_no.)
            REFERENCES Shipping_Info
            ON UPDATE CASCADE
            ON DELETE ON CASCADE)",

            "CREATE TABLE Shipping_info
            (delivery_type CHAR(10),
             Billing_address CHAR(50),
             Shipping_address CHAR [50),
             Shipping_method CHAR [10),
             Phone_number INTEGER,
             Shipping_info_no CHAR(6),
            PRIMARY KEY(Shipping_info_no))"

        );
    }

    function populateAll(){
        global $db_conn, $success; //later try catching exception if oci_commit doesn't go through

        foreach($this->allCreateTables as $createTable){
            $this->SQLExecution->executePlainSql($createTable);
            OCICommit($db_conn);
        }


    }

    function dropAll(){
        global $db_conn;
        $this->SQLExecution->executePlainSQL("Drop table product");
        $this->SQLExecution->executePlainSQL("Drop table Employee");
        OCICommit($db_conn);
    }

}