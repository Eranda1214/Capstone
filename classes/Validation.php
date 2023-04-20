<?php

    // class that handles data validation
    class Validation {

        public function validate($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;
        }

        // function that checks if a string is empty
        private function isEmpty($string) {
            // if the string is empty, return true
            if (empty($string)) {
                return true;
            }
            // otherwise, return false
            return false;
        }

        // function that checks if a string is a valid email
        private function isValidEmail($string) {
            // if the string is a valid email, return true
            if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            // otherwise, return false
            return false;
        }
        // function that checks if a string is a valid password
        private function isValidPassword($string) {
            // if the string is a valid password, return true
            if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $string)) {
                return true;
            }
            // otherwise, return false
            return false;
        }

        private function isValidPhone($string) {
            // if the string is a valid phone number, return true
            if (preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $string)) {
                return true;
            }
            // otherwise, return false
            return false;
        }

        private function isValidPostalCode($string) {
            // if the string is a valid postal code, return true
            if (preg_match('/^[A-Za-z]\d[A-Za-z]?\d[A-Za-z]\d$/', $string)) {
                return true;
            }
            // otherwise, return false
            return false;
        }


        public function validateAuth($email, $password) {
            // create errors array
            $msg = [];
            // if the email is empty
            if ($this->isEmpty($email)) {
                // add an error to the errors array
                $msg['email'] = "<span class='text-danger'>Email must not be empty</span>";
            }
            // if the email is not empty
            else {
                // if the email is not a valid email
                if (!$this->isValidEmail($email)) {
                    // add an error to the errors array
                    $msg['email'] = "<span class='text-danger'>Email is invalid</span>";
                } else {
                    $msg['emailValue'] = $email;
                }
            }
            // if the password is empty
            if ($this->isEmpty($password)) {
                // add an error to the errors array
                $msg['password'] = "<span class='text-danger'>Password must not be empty</span>";
            }
            // if the password is not empty
            else {
                // if the password is not a valid password
                if (!$this->isValidPassword($password)) {
                    // add an error to the errors array
                    $msg['password'] = "<span class='text-danger'>Password is invalid</span>";
                }
            }
            // return the errors array
            return $msg;
        }

        public function validateRegistration($firstName, $lastName, $email, $password, $confirmPassword) {

            // create errors array
            $msg = [];

            // if the first name is empty
            if ($this->isEmpty($firstName)) {
                // add an error to the errors array
                $msg['fname'] = "<span class='text-danger'>First name must not be empty</span>";
            } else {
                $msg['fnameValue'] = $firstName;
            }

            // if the last name is empty
            if ($this->isEmpty($lastName)) {
                // add an error to the errors array
                $msg['lname'] = "<span class='text-danger'>Last name must not be empty</span>";
            } else {
                $msg['lnameValue'] = $lastName;
            }
            // if the email is empty
            if ($this->isEmpty($email)) {
                // add an error to the errors array
                $msg['email'] = "<span class='text-danger'>Email must not be empty</span>";
            }
            // if the email is not empty
            else {
                // if the email is not a valid email
                if (!$this->isValidEmail($email)) {
                    // add an error to the errors array
                    $msg['email'] = "<span class='text-danger'>Email is not valid</span>";
                } else {
                    $msg['emailValue'] = $email;
                }
            }
            // if the password is empty
            if ($this->isEmpty($password)) {
                // add an error to the errors array
                $msg['password'] = "<span class='text-danger'>Password must not be empty</span>";
            }
            // if the password is not empty
            else {
                // if the password is not a valid password
                if (!$this->isValidPassword($password)) {
                    // add an error to the errors array
                    $msg['password'] = "<span class='text-danger'>Password is invalid</span>";
                }
            }
            // if the confirm password is empty
            if ($this->isEmpty($confirmPassword)) {
                // add an error to the errors array
                $msg['confirm_password'] = "<span class='text-danger'>Confirm password must not be empty</span>";
            }
            // if the confirm password is not empty
            else {
                // if the confirm password is not a valid password
                if (!$this->isValidPassword($confirmPassword)) {
                    // add an error to the errors array
                    $msg['confirm_password'] = "<span class='text-danger'>Confirm password is invalid</span>";
                }
            }
            // if the password is not empty and the confirm password is not empty
            if (!$this->isEmpty($password) && !$this->isEmpty($confirmPassword)) {
                // if the password is not equal to the confirm password
                if ($password !== $confirmPassword) {
                    // add an error to the errors array
                    $msg['no_match'] = "<span class='text-danger'>Passwords do not match</span>";
                }
            } 
            // return the errors array
            return $msg;
        }

        public function validateCheckout($orderAddress, $orderCity, $orderProvince, $orderCountry, $orderPostalCode, $orderPhone, $cardNum, $cardExpiry, $cardCvv) {
            // create errors array
            $msg = [];
    
            // if the order address is empty
            if ($this->isEmpty($orderAddress)) {
                // add an error to the errors array
                $msg['orderAddress'] = "<span class='text-danger'>Address must not be empty</span>";
            } else {
                $msg['orderAddressValue'] = $orderAddress;
            }
    
            // if the order city is empty
            if ($this->isEmpty($orderCity)) {
                // add an error to the errors array
                $msg['orderCity'] = "<span class='text-danger'>City must not be empty</span>";
            } else {
                $msg['orderCityValue'] = $orderCity;
            }
    
            // if the order province is empty
            if ($this->isEmpty($orderProvince)) {
                // add an error to the errors array
                $msg['orderProvince'] = "<span class='text-danger'>Province must not be empty</span>";
            } else {
                $msg['orderProvinceValue'] = $orderProvince;
            }
    
            // if the order country is empty
            if ($this->isEmpty($orderCountry)) {
                // add an error to the errors array
                $msg['orderCountry'] = "<span class='text-danger'>Country must not be empty</span>";
            } else {
                $msg['orderCountryValue'] = $orderCountry;
            }
    
            // if the order postal code is empty
            if ($this->isEmpty($orderPostalCode)) {
                // add an error to the errors array
                $msg['orderPostalCode'] = "<span class='text-danger'>Postal code must not be empty</span>";
            } else {
                if(!$this->isValidPostalCode($orderPostalCode)) {
                    $msg['orderPostalCode'] = "<span class='text-danger'>Postal code is invalid</span>";
                }
                $msg['orderPostalCodeValue'] = $orderPostalCode;
            }
    
            // if the order phone is empty
            if ($this->isEmpty($orderPhone)) {
                // add an error to the errors array
                $msg['orderPhone'] = "<span class='text-danger'>Phone number must not be empty</span>";
            } else {
                if(!$this->isValidPhone($orderPhone)) {
                    $msg['orderPhone'] = "<span class='text-danger'>Phone number is invalid</span>";
                }
                $msg['orderPhoneValue'] = $orderPhone;
            }

            // if the card number is empty
            if ($this->isEmpty($cardNum)) {
                // add an error to the errors array
                $msg['cardNum'] = "<span class='text-danger'>Card number must not be empty</span>";
            }

            // if the card expiry is empty
            if ($this->isEmpty($cardExpiry)) {
                // add an error to the errors array
                $msg['cardExpiry'] = "<span class='text-danger'>Card expiry must not be empty</span>";
            }

            // if the card cvv is empty
            if ($this->isEmpty($cardCvv)) {
                // add an error to the errors array
                $msg['cardCvv'] = "<span class='text-danger'>Card cvv must not be empty</span>";
            }
    
            // return the errors array
            return $msg;
        }
    }

    

?>