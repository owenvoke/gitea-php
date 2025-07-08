<?php

declare(strict_types=1);

use OwenVoke\Gitea\Api\Repo;

beforeEach(fn () => $this->apiClass = Repo::class);

it('should show repository', function () {
    $expectedArray = ['name' => 'gitea-php'];

    $api = $this->getApiMock();

    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php')
        ->willReturn($expectedArray);

    expect($api->show('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should show repository by id', function () {
    $expectedArray = ['id' => 123456, 'name' => 'repoName'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repositories/123456')
        ->willReturn($expectedArray);

    expect($api->showById(123456))->toBe($expectedArray);
});

it('should create a repository only using its name', function () {
    $expectedArray = ['id' => 1, 'name' => 'repoName'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/user/repos', [
            'name' => 'repoName',
            'description' => '',
            'homepage' => '',
            'private' => false,
            'license' => '',
            'readme' => '',
            'gitignores' => null,
            'issue_labels' => null,
            'auto_init' => null,
        ])
        ->willReturn($expectedArray);

    expect($api->create('repoName'))->toBe($expectedArray);
});

it('should create a repository for an organisation', function () {
    $expectedArray = ['id' => 1, 'name' => 'FakeOrgsRepo'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/orgs/FakeOrg/repos', [
            'name' => 'repoName',
            'description' => '',
            'homepage' => '',
            'private' => false,
            'license' => '',
            'readme' => '',
            'gitignores' => null,
            'issue_labels' => null,
            'auto_init' => null,
        ])
        ->willReturn($expectedArray);

    expect($api->create('repoName', '', '', true, 'FakeOrg'))->toBe($expectedArray);
});

it('should create a repository with all parameters', function () {
    $expectedArray = ['id' => 1, 'name' => 'repoName'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/user/repos', [
            'name' => 'repoName',
            'description' => 'test',
            'homepage' => 'https://voke.dev',
            'private' => true,
            'license' => 'MIT',
            'readme' => '# Blah',
            'gitignores' => null,
            'issue_labels' => 'MyLabels',
            'auto_init' => true,
        ])
        ->willReturn($expectedArray);

    expect($api->create('repoName', 'test', 'https://voke.dev', false, null, 'MIT', '# Blah', null, 'MyLabels', true))->toBe($expectedArray);
});

it('should generate a repository only using its name', function () {
    $expectedArray = ['id' => 1, 'name' => 'repoName'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/FakeOwner/TemplateRepo/generate', [
            'name' => 'NewRepo',
            'description' => '',
            'private' => false,
            'owner' => 'me',
            'avatar' => true,
            'default_branch' => null,
            'git_content' => true,
            'git_hooks' => true,
            'labels' => true,
            'protected_branch' => true,
            'topics' => true,
            'webhooks' => true,
        ])
        ->willReturn($expectedArray);

    expect($api->generate(
        templateOwner: 'FakeOwner',
        templateName: 'TemplateRepo',
        name: 'NewRepo',
        organization: 'me',
    ))->toBe($expectedArray);
});

it('should get the subscribers for a repository', function () {
    $expectedArray = [['id' => 1, 'username' => 'owenvoke']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/subscribers', ['page' => 2])
        ->willReturn($expectedArray);

    expect($api->subscribers('owenvoke', 'gitea-php', 2))->toBe($expectedArray);
});

it('should get the tags for a repository', function () {
    $expectedArray = [['id' => 1, 'name' => 'v1.0.0', 'commit' => ['sha' => 'meh', 'url' => 'here']]];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/tags', ['page' => 2])
        ->willReturn($expectedArray);

    expect($api->tags('owenvoke', 'gitea-php', 2))->toBe($expectedArray);
});

it('should get the branches for a repository', function () {
    $expectedArray = [['name' => 'main']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/branches')
        ->willReturn($expectedArray);

    expect($api->branches('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should get a branch for a repository', function () {
    $expectedArray = ['name' => 'main'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/branches/main')
        ->willReturn($expectedArray);

    expect($api->branches('owenvoke', 'gitea-php', 'main'))->toBe($expectedArray);
});

it('should get the milestones for a repository', function () {
    $expectedArray = [['id' => 1, 'title' => 'Main']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/milestones')
        ->willReturn($expectedArray);

    expect($api->milestones('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should get the collaborators for a repository', function () {
    $expectedArray = [['id' => 1, 'full_name' => 'Owen Voke']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/collaborators')
        ->willReturn($expectedArray);

    expect($api->collaborators('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should update a repository', function () {
    $expectedArray = [['id' => 1, 'name' => 'gitea-php']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('patch')
        ->with('/repos/owenvoke/gitea-php')
        ->willReturn($expectedArray);

    expect($api->update('owenvoke', 'gitea-php', ['description' => 'test']))->toBe($expectedArray);
});

it('should remove a repository', function () {
    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('delete')
        ->with('/repos/owenvoke/gitea-php')
        ->willReturn(null);

    expect($api->remove('owenvoke', 'gitea-php'))->toBeNull();
});

it('should get topics for a repository', function () {
    $expectedArray = ['topics' => ['gitea', 'php']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/topics')
        ->willReturn($expectedArray);

    expect($api->topics('owenvoke', 'gitea-php'))->toBe($expectedArray);
});

it('should replace topics for a repository', function () {
    $expectedArray = ['topics' => ['gitea', 'php7']];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('put')
        ->with('/repos/owenvoke/gitea-php/topics', ['topics' => ['gitea', 'php8']])
        ->willReturn($expectedArray);

    expect($api->replaceTopics('owenvoke', 'gitea-php', ['gitea', 'php8']))->toBe($expectedArray);
});

it('should transfer a repository', function () {
    $expectedArray = ['id' => 1, 'name' => 'gitea-php'];

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('post')
        ->with('/repos/owenvoke/gitea-php/transfer', [
            'new_owner' => 'other-account',
            'team_ids' => ['1234', '4321'],
        ])
        ->willReturn($expectedArray);

    expect($api->transfer('owenvoke', 'gitea-php', 'other-account', ['1234', '4321']))->toBe($expectedArray);
});

it("should fetch a raw file's data", function () {
    $expectedResponse = '# Gitea PHP';

    $api = $this->getApiMock();
    $api->expects($this->once())
        ->method('get')
        ->with('/repos/owenvoke/gitea-php/raw/README.md')
        ->willReturn($expectedResponse);

    expect($api->getRawFile('owenvoke', 'gitea-php', 'README.md'))->toBe($expectedResponse);
});
