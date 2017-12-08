<?php

return [

    'backup' => [

        /*
         * 备份文件名称,可以用这个名字来监听
         * The name of this application. You can use this name to monitor
         * the backups.
         */
        'name' => config('app.name'),

        /**
         * 备份的资源
         */
        'source' => [

            //备份的文件目录
            'files' => [

                /*
                 * 代码目录
                 * The list of directories and files that will be included in the backup.
                 */
                'include' => [
                    base_path(),
                ],

                /*
                 * 排除备份目录
                 * These directories and files will be excluded from the backup.
                 *
                 * Directories used by the backup process will automatically be excluded.
                 */
                'exclude' => [
                    base_path('vendor'),
                    base_path('node_modules'),
                ],

                /*
                 * 连接一起是否备份
                 * Determines if symlinks should be followed.
                 */
                'followLinks' => false,
            ],

            /*
             * 数据库备份配置
             * The names of the connections to the databases that should be backed up
             * MySQL, PostgreSQL, SQLite and Mongo databases are supported.
             */
            'databases' => [
                'mysql',
            ],
        ],

        /*
         * 可以压缩数据库转储以减少磁盘空间的使用。
         * The database dump can be gzipped to decrease diskspace usage.
         */
        'gzip_database_dump' => false,

        'destination' => [

            /*
             * 文件前缀
             * The filename prefix used for the backup zip file.
             */
            'filename_prefix' => '',

            /*
             * 备份将被存储的磁盘名称。
             * The disk names on which the backups will be stored.
             */
            'disks' => [
                'local',
            ],
        ],
    ],

    /*
     * 当特定事件发生时，您可以得到通知。从盒子里你可以使用“邮件”和“slack”。
     * 对于Slack来说，你需要安装“guzzlehttp/guzzle”。
     * You can get notified when specific events occur. Out of the box you can use 'mail' and 'slack'.
     * For Slack you need to install guzzlehttp/guzzle.
     *
     * 您还可以使用自己的通知类，只需要确保类的名称是
     * 空间备份事件类。
     * You can also use your own notification classes, just make sure the class is named after one of
     * the `Spatie\Backup\Events` classes.
     */
    'notifications' => [

        'notifications' => [
            //备份失败
            \Spatie\Backup\Notifications\Notifications\BackupHasFailed::class         => ['mail'],
            //检测备份存在问题
            \Spatie\Backup\Notifications\Notifications\UnhealthyBackupWasFound::class => ['mail'],
            //清除备份失败
            \Spatie\Backup\Notifications\Notifications\CleanupHasFailed::class        => ['mail'],
            //备份成功
            \Spatie\Backup\Notifications\Notifications\BackupWasSuccessful::class     => ['mail'],
            //检测备份OK
            \Spatie\Backup\Notifications\Notifications\HealthyBackupWasFound::class   => ['mail'],
            //成功清理备份
            \Spatie\Backup\Notifications\Notifications\CleanupWasSuccessful::class    => ['mail'],
        ],

        /*
         * Here you can specify the notifiable to which the notifications should be sent. The default
         * notifiable will use the variables specified in this config file.
         */
        'notifiable' => \Spatie\Backup\Notifications\Notifiable::class,

        'mail' => [
            'to' => env('BACKUP_NOTIFICATIONS_MAIL',env('MAIL_USERNAME')),
        ],

        'slack' => [
            'webhook_url' => '',

            /*
             * If this is set to null the default channel of the webhook will be used.
             */
            'channel' => null,
        ],
    ],

    /*
     * Here you can specify which backups should be monitored.
     * If a backup does not meet the specified requirements the
     * UnHealthyBackupWasFound event will be fired.
     */
    'monitorBackups' => [
        [
            'name' => config('app.name'),
            'disks' => ['local'],
            'newestBackupsShouldNotBeOlderThanDays' => 1,
            'storageUsedMayNotBeHigherThanMegabytes' => 5000,
        ],

        /*
        [
            'name' => 'name of the second app',
            'disks' => ['local', 's3'],
            'newestBackupsShouldNotBeOlderThanDays' => 1,
            'storageUsedMayNotBeHigherThanMegabytes' => 5000,
        ],
        */
    ],

    'cleanup' => [
        /*
         * The strategy that will be used to cleanup old backups. The default strategy
         * will keep all backups for a certain amount of days. After that period only
         * a daily backup will be kept. After that period only weekly backups will
         * be kept and so on.
         *
         * No matter how you configure it the default strategy will never
         * delete the newest backup.
         */
        'strategy' => \Spatie\Backup\Tasks\Cleanup\Strategies\DefaultStrategy::class,

        'defaultStrategy' => [

            /*
             * The number of days for which backups must be kept.
             */
            'keepAllBackupsForDays' => 7,

            /*
             * The number of days for which daily backups must be kept.
             */
            'keepDailyBackupsForDays' => 16,

            /*
             * The number of weeks for which one weekly backup must be kept.
             */
            'keepWeeklyBackupsForWeeks' => 8,

            /*
             * The number of months for which one monthly backup must be kept.
             */
            'keepMonthlyBackupsForMonths' => 4,

            /*
             * The number of years for which one yearly backup must be kept.
             */
            'keepYearlyBackupsForYears' => 2,

            /*
             * After cleaning up the backups remove the oldest backup until
             * this amount of megabytes has been reached.
             */
            'deleteOldestBackupsWhenUsingMoreMegabytesThan' => 5000,
        ],
    ],
];
