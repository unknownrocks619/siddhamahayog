<?php
namespace App\Classes\Helpers\Roles;

enum Rule : int {

    case GUEST = 0;
    case SUPER_ADMIN = 1;
    case CENTER = 2;
    case SADHAK = 3;
    case TEACHER = 4;
    case ADMIN_TEACHER = 5;
    case MARKETING = 6;
    case MEMBER = 7;
    case SUPPORT = 8;
    case CENTER_ADMIN = 9;
    case DHARMASALA = 10;
    case COHOST = 11;
    case ACTING_ADMIN = 12;
    case ADMIN = 13;

    /**
     * @info check of super admin
     */
    public function isSuperAdmin(): bool {
        return $this == self::SUPER_ADMIN;
    }

    public function isCenter(): bool{
        return $this == self::CENTER;
    }

    public function isSadhak(): bool{
        return $this == self::SADHAK;
    }

    public function isTeacher(): bool{
        return $this == self::TEACHER;
    }

    public function isAdminTeacher(): bool{
        return $this == self::ADMIN_TEACHER;
    }

    public function isMarketing(): bool{
        return $this == self::MARKETING;
    }

    public function isMember(): bool{
        return $this == self::MEMBER;
    }

    public function isSupport(): bool{
        return $this == self::SUPPORT;
    }

    public function isCenterAdmin(): bool{
        return $this == self::CENTER_ADMIN;
    }

    public function isDharmasala(): bool{
        return $this == self::DHARMASALA;
    }
    public function isCohost(): bool{
        return $this == self::COHOST;
    }

    public function isActingAdmin(): bool{
        return $this == self::ACTING_ADMIN;
    }

    public function isAdmin(): bool{
        return $this == self::ADMIN;
    }

    public function isGuest() : bool {
        return $this == self::GUEST;
    }

    public function role() {
        return $this;
    }

}