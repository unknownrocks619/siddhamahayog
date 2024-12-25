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

    /**
     * @return bool
     */
    public function isCenter(): bool{
        return $this == self::CENTER;
    }

    /**
     * @return bool
     */
    public function isSadhak(): bool{
        return $this == self::SADHAK;
    }

    /**
     * @return bool
     */
    public function isTeacher(): bool{
        return $this == self::TEACHER;
    }

    /**
     * @return bool
     */
    public function isAdminTeacher(): bool{
        return $this == self::ADMIN_TEACHER;
    }

    /**
     * @return bool
     */
    public function isMarketing(): bool{
        return $this == self::MARKETING;
    }

    /**
     * @return bool
     */
    public function isMember(): bool{
        return $this == self::MEMBER;
    }

    /**
     * @return bool
     */
    public function isSupport(): bool{
        return $this == self::SUPPORT;
    }

    /**
     * @return bool
     */
    public function isCenterAdmin(): bool{
        return $this == self::CENTER_ADMIN;
    }

    /**
     * @return bool
     */
    public function isDharmasala(): bool{
        return $this == self::DHARMASALA;
    }

    /**
     * @return bool
     */
    public function isCohost(): bool{
        return $this == self::COHOST;
    }

    /**
     * @return bool
     */
    public function isActingAdmin(): bool{
        return $this == self::ACTING_ADMIN;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool{
        return $this == self::ADMIN;
    }

    /**
     * @return bool
     */
    public function isGuest() : bool {
        return $this == self::GUEST;
    }

    /**
     * @return $this
     */
    public function role() {
        return $this;
    }

}
