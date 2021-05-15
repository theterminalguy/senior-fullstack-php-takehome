<?php

namespace Application\config;

interface IDatabaseAdapter {
    public function getConnection();
}
