from tools.fablib import *

"""
Base configuration
"""
env.project_name = 'lens'
env.file_path = '.'

"""
Add HipChat info to send a message to a room when new code has been deployed.
"""
try:
    env.hipchat_token = os.environ['HIPCHAT_DEPLOYMENT_NOTIFICATION_TOKEN']
    env.hipchat_room_id = os.environ['HIPCHAT_DEPLOYMENT_NOTIFICATION_ROOM_ID']
except KeyError:
    pass

# Environments
def production():
    """
    Work on production environment
    """
    env.settings = 'production'
    env.hosts = [os.environ['LENS_PRODUCTION_SFTP_HOST'], ]
    env.user = os.environ['LENS_PRODUCTION_SFTP_USER']
    env.password = os.environ['LENS_PRODUCTION_SFTP_PASSWORD']


def staging():
    """
    Work on staging environment
    """
    env.settings = 'staging'
    env.hosts = [os.environ['LENS_STAGING_SFTP_HOST'], ]
    env.user = os.environ['LENS_STAGING_SFTP_USER']
    env.password = os.environ['LENS_STAGING_SFTP_PASSWORD']

try:
    from local_fabfile import  *
except ImportError:
    pass
