<?php

namespace App\Helpers;

/**
 * SubmissionHelper
 * 
 * Centralized helper class for managing submission configurations
 * and filtering based on active competition stages.
 * 
 * This class provides a clean, reusable interface for working with
 * submission requirements throughout the application.
 */
class SubmissionHelper
{
    /**
     * Get the list of currently active competition stages.
     *
     * @return array Array of active stage names (e.g., ['preliminary'])
     */
    public static function getActiveStages(): array
    {
        return config('submissions.active_stages', ['preliminary']);
    }

    /**
     * Check if a specific stage is currently active.
     *
     * @param string $stage The stage to check (preliminary, semifinal, final)
     * @return bool True if the stage is active, false otherwise
     */
    public static function isStageActive(string $stage): bool
    {
        return in_array($stage, self::getActiveStages());
    }

    /**
     * Filter requirements to only include active stages.
     *
     * @param array $requirements The full array of submission requirements
     * @return array Filtered requirements containing only active stages
     */
    public static function filterActiveRequirements(array $requirements): array
    {
        $activeStages = self::getActiveStages();
        
        return array_values(array_filter($requirements, function ($requirement) use ($activeStages) {
            return isset($requirement['stage']) && in_array($requirement['stage'], $activeStages);
        }));
    }

    /**
     * Get submission requirements for a specific category, optionally filtered by active stages.
     *
     * @param string $category The competition category (business_case, geothermal, etc.)
     * @param bool $activeOnly Whether to return only active stage requirements
     * @return array Array of submission requirements
     */
    public static function getRequirementsForCategory(string $category, bool $activeOnly = true): array
    {
        $config = config("submissions.categories.{$category}");
        
        if (!$config || !isset($config['requirements'])) {
            return [];
        }
        
        $requirements = $config['requirements'];
        
        if ($activeOnly) {
            $requirements = self::filterActiveRequirements($requirements);
        }
        
        return $requirements;
    }

    /**
     * Get stage display names.
     *
     * @return array Associative array mapping stage keys to display names
     */
    public static function getStageNames(): array
    {
        return config('submissions.stage_display_names', [
            'preliminary' => 'Preliminary Round',
            'semifinal' => 'Semifinal Round',
            'final' => 'Final Round',
        ]);
    }

    /**
     * Get display name for a specific stage.
     *
     * @param string $stage The stage key
     * @return string The display name for the stage
     */
    public static function getStageName(string $stage): string
    {
        $names = self::getStageNames();
        return $names[$stage] ?? ucfirst($stage);
    }

    /**
     * Get the list of active stages with their display names.
     *
     * @return array Associative array of active stages with display names
     */
    public static function getActiveStagesWithNames(): array
    {
        $activeStages = self::getActiveStages();
        $stageNames = self::getStageNames();
        
        $result = [];
        foreach ($activeStages as $stage) {
            $result[$stage] = $stageNames[$stage] ?? ucfirst($stage);
        }
        
        return $result;
    }

    /**
     * Validate if a submission type and stage combination is valid and active.
     *
     * @param string $category The competition category
     * @param string $submissionType The submission type
     * @param string $stage The competition stage
     * @return bool True if valid and active, false otherwise
     */
    public static function isValidSubmission(string $category, string $submissionType, string $stage): bool
    {
        // Check if stage is active
        if (!self::isStageActive($stage)) {
            return false;
        }
        
        // Check if submission type exists for this category and stage
        $requirements = self::getRequirementsForCategory($category, false);
        
        foreach ($requirements as $requirement) {
            if ($requirement['type'] === $submissionType && $requirement['stage'] === $stage) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get a specific requirement configuration.
     *
     * @param string $category The competition category
     * @param string $submissionType The submission type
     * @param string $stage The competition stage
     * @return array|null The requirement configuration or null if not found
     */
    public static function getRequirement(string $category, string $submissionType, string $stage): ?array
    {
        $requirements = config("submissions.categories.{$category}.requirements", []);
        
        foreach ($requirements as $requirement) {
            if ($requirement['type'] === $submissionType && $requirement['stage'] === $stage) {
                return $requirement;
            }
        }
        
        return null;
    }

    /**
     * Get the maximum file size for a specific submission.
     *
     * @param string $category The competition category
     * @param string $submissionType The submission type
     * @param string $stage The competition stage
     * @return int The maximum file size in MB
     */
    public static function getMaxFileSize(string $category, string $submissionType, string $stage): int
    {
        $requirement = self::getRequirement($category, $submissionType, $stage);
        
        if ($requirement && isset($requirement['max_size'])) {
            return $requirement['max_size'];
        }
        
        return config('submissions.settings.default_max_size', 10);
    }

    /**
     * Get allowed file extensions.
     *
     * @return array Array of allowed file extensions
     */
    public static function getAllowedExtensions(): array
    {
        return config('submissions.settings.allowed_extensions', ['pdf']);
    }

    /**
     * Get allowed MIME types.
     *
     * @return array Array of allowed MIME types
     */
    public static function getAllowedMimeTypes(): array
    {
        return config('submissions.settings.allowed_mime_types', ['application/pdf']);
    }
}
