pipeline {
    agent any

    parameters {
        string(name: 'GIT_REPO', defaultValue: 'https://github.com/dennys0402/Rest-API-TDD.git', description: 'URL del repositorio de Git')
        string(name: 'GIT_BRANCH', defaultValue: 'main', description: 'Rama del repositorio de Git')
        string(name: 'PHP_PATH', defaultValue: 'C:/xampp/php/php.exe', description: 'Ruta de PHP')
        string(name: 'COMPOSER_PATH', defaultValue: 'C:/ProgramData/ComposerSetup/bin/composer.bat', description: 'Ruta de Composer')
        string(name: 'DB_HOST', defaultValue: '127.0.0.1', description: 'Host de la base de datos')
        string(name: 'DB_PORT', defaultValue: '3306', description: 'Puerto de la base de datos')
        string(name: 'DB_DATABASE', defaultValue: 'laravel', description: 'Nombre de la base de datos')
        string(name: 'DB_USERNAME', defaultValue: 'root', description: 'Usuario de la base de datos')
        string(name: 'DB_PASSWORD', defaultValue: '', description: 'Contraseña de la base de datos')
    }

    environment {
        PHP_PATH = "${params.PHP_PATH}"
        COMPOSER_PATH = "${params.COMPOSER_PATH}"
    }

    stages {
        stage('Clone Repository') {
            steps {
                script {
                    // Clonar el repositorio de GitHub
                    git url: "${params.GIT_REPO}", branch: "${params.GIT_BRANCH}"
                }
            }
        }
        
        stage('Install Dependencies') {
            steps {
                script {
                    // Instalar las dependencias de Composer
                    bat "${COMPOSER_PATH} install"
                }
            }
        }

        stage('Configure Laravel Environment') {
            steps {
                script {
                    // Crear archivo .env con los parámetros proporcionados
                    bat """
                    echo APP_NAME=Laravel > .env
                    echo APP_ENV=local >> .env
                    echo APP_KEY= >> .env 
                    echo APP_DEBUG=true >> .env
                    echo APP_URL=http://localhost >> .env
                    echo DB_CONNECTION=mysql >> .env
                    echo DB_HOST=${params.DB_HOST} >> .env
                    echo DB_PORT=${params.DB_PORT} >> .env
                    echo DB_DATABASE=${params.DB_DATABASE} >> .env
                    echo DB_USERNAME=${params.DB_USERNAME} >> .env
                    echo DB_PASSWORD=${params.DB_PASSWORD} >> .env
                    """
                    
                    // Generar clave de aplicación
                    bat "${PHP_PATH} artisan key:generate"
                }
            }
        }

        stage('Run Migrations') {
            steps {
                script {
                    // Ejecutar migraciones y seeders
                    bat "${PHP_PATH} artisan migrate --seed --force"
                }
            }
        }
    }

    post {
        success {
            echo 'Pipeline completed successfully!'
        }
        failure {
            echo 'Pipeline failed!'
        }
    }
}
